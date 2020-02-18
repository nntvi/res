<?php

namespace App\Repositories\PermissionDetailRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionDetailRepository\IPermissionDetailRepository;

use App\PermissionDetail;
use App\Permission;
class PermissionDetailRepository extends Controller implements IPermissionDetailRepository{

    public function showAllDetail()
    {
        $permissionDetails = PermissionDetail::paginate(3);
        return view('permissiondetail/index', compact('permissionDetails'));
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
