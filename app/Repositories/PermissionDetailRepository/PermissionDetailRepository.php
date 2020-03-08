<?php

namespace App\Repositories\PermissionDetailRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionDetailRepository\IPermissionDetailRepository;

use App\PermissionDetail;
use App\Permission;
class PermissionDetailRepository extends Controller implements IPermissionDetailRepository{

    public function showAllDetail()
    {
        $permissionDetails = PermissionDetail::paginate(5);
        return view('permissiondetail/index', compact('permissionDetails'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'action_name.required' => 'Không để trống tên quyền',
            'action_name.min' => 'Tên quyền nhiều hơn 3 ký tự',
            'action_name.max' => 'Tên quyền giới hạn 30 ký tự',
            'action_name.unique' => 'Tên quyền vừa nhập đã tồn tại trong hệ thống',
        ];

        $req->validate(
            [
                'action_name' => 'required|min:3|max:30|unique:permission__details,name',
            ],
            $messeages
        );
    }
    public function convertActionCode($str)
    {
        $s = strtoupper($str);
        $s = str_replace(' ','_',$s);
        return $s;
    }

    public function deleteDetail($id)
    {
        $permissionDetail = PermissionDetail::find($id)->delete();
        return redirect(route('perdetail.index'));
    }
}
