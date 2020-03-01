<?php

namespace App\Http\Controllers;
use App\Helper\ICheckAction;
use App\Repositories\PermissionRepository\IPermissionRepository;
use App\Permission;
use App\PermissionAction;
use App\PermissionDetail;
use Illuminate\Http\Request;
use Redirect;

class PermissionController extends Controller
{
    private $checkAction;
    private $permissionRepository;

    public function __construct(ICheckAction $checkAction, IPermissionRepository $permissionRepository )
    {
        $this->checkAction = $checkAction;
        $this->permissionRepository = $permissionRepository;
    }

    // show permission
    public function index(){
        return $this->permissionRepository->showAllPermission();
    }

    // store permission
    public function store(Request $req){
        $this->permissionRepository->validatorRequestStore($req);
        return $this->permissionRepository->addPermission($req);
    }

    // view Update Permission
    public function getEdit($id)
    {
        $permissiondetails = $this->permissionRepository->getPermissionDetail();
        $permission = $this->permissionRepository->findPermission($id);
        $peractions = $this->permissionRepository->getPerActionById($id);

        $data = $this->permissionRepository->getOldPerDetail($permissiondetails,$peractions);
        return view('permission/update',compact('permission','data', 'permissiondetails'));
    }

    // post Update Permission
    public function postEdit(Request $req, $id)
    {
        $permission = $this->permissionRepository->findPermission($id);
        return $this->permissionRepository->updatePermission($req,$permission);
    }

    // delete Permission
    public function delete($id)
    {
        return $this->permissionRepository->deletePermission($id);
    }
}
