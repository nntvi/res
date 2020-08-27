<?php
namespace App\Repositories\AreaRepository;

use App\Area;
use App\Table;
use App\Http\Controllers\Controller;
use App\Repositories\AreaRepository\IAreaRepository;

class AreaRepository extends Controller implements IAreaRepository{

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
        $areas = Area::where('status','1')->with(['containTable' => function ($query)
                {
                    $query->where('status','1');
                }])->orderBy('name', 'desc')->get();
        return $areas;
    }

    public function validatorArea($request)
    {
        $request->validate(
            ['nameArea' => 'status_area|special_character'],
            [
                'nameArea.status_area' => 'Tên khu vực đã tồn tại trong hệ thống',
                'nameArea.special_character' => 'Tên khu vực không chứa các ký tự đặc biệt'
            ]
        );
    }

    public function addArea($request)
    {
        $area = new Area();
        $area->name = $request->nameArea;
        $area->status = '1';
        $area->save();
        return redirect(route('area.index'))->withSuccess('Thêm khu vực thành công');
    }

    public function updateArea($req,$id)
    {
        $area = Area::find($id);
        $area->name = $req->nameArea;
        $area->save();
        return redirect(route('area.index'))->withSuccess('Cập nhật thành công');
    }

    public function deleteArea($id)
    {
        Table::where('id_area',$id)->update(['status' => '0']);
        Area::where('id',$id)->update(['status' => '0']);
        return redirect(route('area.index'))->withSuccess('Xóa khu vực thành công');
    }

}
