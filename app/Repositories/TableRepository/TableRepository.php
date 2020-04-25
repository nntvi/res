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

    public function validatorRequestStore($req){
        $req->validate(
            [
                'codeTable' => 'unique:tables,code',
                'nameTable' => 'unique:tables,name',
            ],
            [
                'codeTable.unique' => 'Mã bàn đã tồn tại trong hệ thống',
                'nameTable.unique' => 'Tên bàn đã tồn tại trong hệ thống',
            ]
        );
    }

    public function addTable($request)
    {
        $table = new Table();
        $table->code = $request->codeTable;
        $table->name = $request->nameTable;
        $table->id_area = $request->idArea;
        $table->save();
        return redirect(route('table.index'));
    }

    public function updateNameTable($request,$id)
    {
        Table::where('id',$id)->update(['name' => $request->nameTable]);
        return redirect(route('table.index'));
    }

    public function updateArea($request,$id)
    {
        Table::where('id',$id)->update(['id_area' => $request->idArea]);
        return redirect(route('table.index'));
    }

    public function searchTable($request)
    {
        $search = $request->nameSearch;
        $tables = Table::where('name','LIKE',"%{$search}%")
                        ->orwhere('code','LIKE',"{$search}")
                        ->get();
        $areas = $this->getAllArea();
        return view('table.search',compact('tables','areas'));
    }
    public function deleteTable($id)
    {
        Table::find($id)->delete();
        return redirect(route('table.index'));
    }
}
