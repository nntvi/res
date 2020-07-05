<?php
namespace App\Repositories\TableRepository;

use App\Http\Controllers\Controller;
use App\Repositories\TableRepository\ITableRepository;
use App\Area;
use App\Table;

class TableRepository extends Controller implements ITableRepository{

    public function getAllArea()
    {
        $areas = Area::all();
        return $areas;
    }
    public function getAllTable()
    {
        $tables = Table::with('getArea')->paginate(8);
        $areas = $this->getAllArea();
        return view('table/index',compact('tables','areas'));
    }

    public function validateCodeTable($request)
    {
        $request->validate(['codeTable' => 'code_table'],['codeTable.code_table' => 'Mã bàn đã tồn tại trong hệ thống']);
    }

    public function validatorNameTable($req){
        $req->validate(['nameTable' => 'status_table'],['nameTable.status_table' => 'Tên bàn đã tồn tại trong hệ thống']);
    }

    public function addTable($request)
    {
        $table = new Table();
        $table->code = $request->codeTable;
        $table->name = $request->nameTable;
        $table->status = '1';
        $table->chairs = $request->qtyChairs;
        $table->id_area = $request->idArea;
        $table->save();
        return redirect(route('area.index'))->withSuccess('Thêm bàn thành công');
    }

    public function updateNameTable($request,$id)
    {
        Table::where('id',$id)->update(['name' => $request->nameTable]);
    }

    public function updateAreaTable($request,$id)
    {
        Table::where('id',$id)->update(['id_area' => $request->changeArea]);
    }

    public function updateChair($request,$id)
    {
        Table::where('id',$id)->update(['chairs' => $request->qtyChairs]);
    }

    public function searchTable($request)
    {
        $search = $request->nameSearch;
        $tables = Table::where('name','LIKE',"%{$search}%")->orwhere('code','LIKE',"{$search}")->get();
        $areas = $this->getAllArea();
        return view('table.search',compact('tables','areas'));
    }
    public function deleteTable($id)
    {
        Table::where('id',$id)->update(['status' => '0']);
        return redirect(route('area.index'))->withSuccess('Xóa bàn thành công');
    }
}
