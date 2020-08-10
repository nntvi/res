<?php
namespace App\Repositories\TableRepository;

use App\Http\Controllers\Controller;
use App\Repositories\TableRepository\ITableRepository;
use App\Area;
use App\Table;

class TableRepository extends Controller implements ITableRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_KHU_VUC"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "TAO_KHU_VUC"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_KHU_VUC"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleDelete($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XOA_KHU_VUC"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getAllArea()
    {
        $areas = Area::all();
        return $areas;
    }
    public function getAllTable()
    {
        $tables = Table::with('getArea')->get();
        $areas = $this->getAllArea();
        return view('table/index',compact('tables','areas'));
    }

    public function validateCodeTable($request)
    {
        $request->validate(['codeTable' => 'code_table'],['codeTable.code_table' => 'Mã bàn đã tồn tại trong hệ thống']);
    }

    public function validateNameTable($req){
        $req->validate(
            ['nameTable' => 'status_table|regex:[\w\s]'],
            [
                'nameTable.status_table' => 'Tên bàn đã tồn tại trong hệ thống',
                'nameTable.regex' => 'Tên bàn không chứa kí tự đặc biệt'
            ],
        );
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

    public function deleteTable($id)
    {
        Table::where('id',$id)->update(['status' => '0']);
    }
}
