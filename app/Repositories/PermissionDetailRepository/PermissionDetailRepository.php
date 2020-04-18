<?php

namespace App\Repositories\PermissionDetailRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionDetailRepository\IPermissionDetailRepository;

use App\PermissionDetail;
use App\Permission;
use App\PermissionAction;

class PermissionDetailRepository extends Controller implements IPermissionDetailRepository{

    public function showAllDetail()
    {
        $permissionDetails = PermissionDetail::orderBy('name','asc')->paginate(7);
        return view('permissiondetail/index', compact('permissionDetails'));
    }

    public function validatorRequestStore($req){
        $req->validate(['action_name' => 'unique:permission__details,name',],
                        ['action_name.unique' => 'Tên quyền vừa nhập đã tồn tại trong hệ thống']);
    }

    public function convertActionCode($str)
    {
        $s = strtoupper($str);
        $s = str_replace(' ','_',$s);
        return $s;
    }

    public function storePermissionDetail($request)
    {
        $detail = new PermissionDetail();
        $detail->name = $request->action_name;
        $s = $this->convertActionCode($request->action_name);
        $detail->action_code = $s;
        $detail->save();
        return redirect(route('perdetail.index'));
    }

    public function updatePermissionDetail($request, $id)
    {
        PermissionDetail::where('id',$id)->update(array('name' => $request->action_name,
                                                    'action_code' => $s = $this->convertActionCode($request->action_name)));
        return redirect(route('perdetail.index'));
    }

    public function searchPermissionDetail($request)
    {
        $name = $request->nameSearch;
        $permissionDetails = PermissionDetail::where('name','LIKE',"%{$name}%")->get();
        return view('permissiondetail.search',compact('permissionDetails'));
    }
    public function deleteDetail($id)
    {
        PermissionDetail::find($id)->delete();
        PermissionAction::where('id_per_detail',$id)->delete();
        return redirect(route('perdetail.index'));
    }
}
