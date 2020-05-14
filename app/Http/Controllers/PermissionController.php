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

    public function index(){
        return $this->permissionRepository->showAllPermission();
    }

    public function search(Request $request)
    {
        return $this->permissionRepository->searchMaterial($request);
    }

    public function store(Request $req){
        $this->permissionRepository->validatorRequestStore($req);
        return $this->permissionRepository->addPermission($req);
    }

    public function viewUpdateDetail($id)
    {
        $permissiondetails = $this->permissionRepository->getPermissionDetail();
        $permission = $this->permissionRepository->findPermission($id);
        $peractions = $this->permissionRepository->getPerActionById($id);
        $data = $this->permissionRepository->getOldPerDetail($permissiondetails,$peractions);
        return view('permission/update',compact('permission','data', 'permissiondetails'));
    }

    public function postEdit(Request $req, $id)
    {
        $this->permissionRepository->validatorRequestStore($req);
        $permission = $this->permissionRepository->findPermission($id);
        return $this->permissionRepository->updatePermission($req,$permission);
    }

    public function updateName(Request $request, $id)
    {
        $this->permissionRepository->validateUpdateName($request);
        return $this->permissionRepository->updateName($request,$id);
    }
    public function updateDetail(Request $req, $id)
    {
        $this->permissionRepository->validateUpdateDetail($req);
        $permission = $this->permissionRepository->findPermission($id);
        return $this->permissionRepository->updatePermission($req,$permission);
    }

    public function delete($id)
    {
        return $this->permissionRepository->deletePermission($id);
    }
}
