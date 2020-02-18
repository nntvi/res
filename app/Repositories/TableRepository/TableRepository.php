<?php
namespace App\Repositories\TableRepository;

use App\Http\Controllers\Controller;
use App\Repositories\TableRepository\ITableRepository;
use App\Area;
use App\Table;

class TableRepository extends Controller implements ITableRepository{
    public function getAllTable()
    {
        $tables = Table::with('getArea')->get();
        return view('table/index',compact('tables'));
    }

    public function viewAddTable()
    {
        $areas = Area::all();
        return view('table/store',compact('areas'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'codeTable.required' => 'Không để trống mã bàn',
            'codeTable.min' => 'Mã bàn nhiều hơn 3 ký tự',
            'codeTable.max' => 'Mã bàn giới hạn 15 ký tự',
            'codeTable.unique' => 'Mã bàn đã tồn tại trong hệ thống',

            'nameTable.required' => 'Không để trống tên bàn',
            'nameTable.min' => 'Mã bàn nhiều hơn 3 ký tự',
            'nameTable.max' => 'Mã bàn giới hạn 10 ký tự',
        ];

        $req->validate(
            [
                'codeTable' => 'required|min:3|max:15|unique:tables,code',
                'nameTable' => 'required|min:3|max:10',
            ],
            $messeages
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

    public function viewUpdateTable($id)
    {
        $table = Table::find($id);
        $areas = Area::all();
        return view('table.update',compact('table','areas'));
    }

    public function updateTable($request, $id)
    {
        $table = Table::find($id);
        $table->name = $request->nameTable;
        $table->id_area = $request->idArea;
        $table->save();
        return redirect(route('table.index'));
    }

    public function deleteTable($id)
    {
        Table::find($id)->delete();
        return redirect(route('table.index'));
    }
}
