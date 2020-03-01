<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\ICheckAction;
use App\Repositories\PermissionDetailRepository\IPermissionDetailRepository;
use App\Permission;
use App\PermissionAction;
use App\PermissionDetail;
use Redirect;

class PermissionDetailController extends Controller
{
    private $checkAction;
    private $permissionDetailRepository;

    public function __construct(ICheckAction $checkAction,IPermissionDetailRepository $permissionDetailRepository)
    {
        $this->checkAction = $checkAction;
        $this->permissionDetailRepository = $permissionDetailRepository;
    }

    // view detail
    public function index()
    {
        return $this->permissionDetailRepository->showAllDetail();
    }

    public function store(Request $req)
    {
        $permissions = $req->permission;
        $input['name'] = $req->action_name;
        $str =  $req->action_name;
        $s = $this->permissionDetailRepository->convertActionCode($str);
        $input['action_code'] = $s;
        PermissionDetail::create($input);
        return redirect(route('perdetail.index'));
    }

    public function getEdit($id)
    {
        $permissionDetails = PermissionDetail::find($id);
        return view('permissiondetail.update',compact('permissionDetails'));
    }

    public function postEdit(Request $req, $id)
    {
        $permissionDetail = PermissionDetail::find($id);
        $permissionDetail->name = $req->action_name;
        $str =  $req->action_name;
        $s = $this->permissionDetailRepository->convertActionCode($str);
        $permissionDetail->action_code = $s;
        $permissionDetail->save();
        return redirect(route('perdetail.index'));
    }
    public function delete($id)
    {
       return $this->permissionDetailRepository->deleteDetail($id);
    }
}
