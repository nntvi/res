<?php
namespace App\Repositories\AreaRepository;

use App\Area;
use App\Table;
use App\Http\Controllers\Controller;
use App\Repositories\AreaRepository\IAreaRepository;

class AreaRepository extends Controller implements IAreaRepository{

    public function getAllArea()
    {
        $areas = Area::where('status','1')->orderBy('name', 'asc')->with('containTable.getArea')->paginate(2);
        return $areas;
    }

    public function validatorArea($request)
    {
        $request->validate(['nameArea' => 'status_area'],['nameArea.status_area' => 'Tên khu vực đã tồn tại trong hệ thống']);
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
