<?php
namespace App\Repositories\AreaRepository;

use App\Http\Controllers\Controller;
use App\Repositories\AreaRepository\IAreaRepository;
use App\Area;
use App\Table;

class AreaRepository extends Controller implements IAreaRepository{
    public function getAllArea()
    {
        $areas = Area::orderBy('name', 'asc')->get();
        return view('area/index',compact('areas'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'nameArea.required' => 'Không để trống tên khu vực',
            'nameArea.min' => 'Tên khu vực nhiều hơn 3 ký tự',
            'nameArea.max' => 'Tên khu vực giới hạn 30 ký tự',
            'nameArea.unique' => 'Tên khu vực đã tồn tại trong hệ thống'
        ];

        $req->validate(
            [
                'nameArea' => 'required|min:3|max:30|unique:areas,name',
            ],
            $messeages
        );
    }

    public function validatorRequestUpdate($req){
        $messeages = [
            'AreaName.required' => 'Không để trống tên khu vực',
            'AreaName.mix' => 'Tên khu vực nhiều hơn 3 ký tự',
            'AreaName.max' => 'Tên khu vực giới hạn 30 ký tự',
            'AreaName.unique' => 'Tên khu vực đã tồn tại trong hệ thống'
        ];

        $req->validate(
            [
                'AreaName' => 'required|min:3|max:30|unique:areas,name',
            ],
            $messeages
        );
    }

    public function addArea($req)
    {
        $area = new Area();
        $area->name = $req->nameArea;
        dd($area);
        $area->save();
        return redirect(route('area.index'))->with('success',"Thêm thành công");
    }

    public function updateArea($req,$id)
    {
        $area = Area::find($id);
        $area->name = $req->AreaName;
        $area->save();
        return redirect(route('area.index'));
    }

    public function deleteArea($id)
    {
        Table::where('id_area',$id)->delete();
        $area = Area::find($id)->delete();
        return redirect(route('area.index'));
    }
}
