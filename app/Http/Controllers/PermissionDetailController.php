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

    public function index()
    {
        return $this->permissionDetailRepository->showAllDetail();
    }

    public function store(Request $req)
    {
        $this->permissionDetailRepository->validatorRequestStore($req);
        return $this->permissionDetailRepository->storePermissionDetail($req);
    }

    public function postEdit(Request $req, $id)
    {
        $this->permissionDetailRepository->validatorRequestStore($req);
        return $this->permissionDetailRepository->updatePermissionDetail($req,$id);
    }

    public function search(Request $request)
    {
        return $this->permissionDetailRepository->searchPermissionDetail($request);
    }
    public function delete($id)
    {
       return $this->permissionDetailRepository->deleteDetail($id);
    }
}
