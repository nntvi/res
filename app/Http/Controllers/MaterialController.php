<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;
use App\Repositories\MaterialRepository\IMaterialRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MaterialExport;
use App\Helper\ICheckAction;

class MaterialController extends Controller
{
    private $materialRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IMaterialRepository $materialRepository)
    {
        $this->checkAction = $checkAction;
        $this->materialRepository = $materialRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->materialRepository->showMaterial();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function store(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialRepository->checkRoleStore($result);
        if($check != 0){
            $this->materialRepository->validatorRequestStore($request);
            return $this->materialRepository->addMaterial($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateName(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->materialRepository->validatorRequestUpdate($request);
            return $this->materialRepository->updateNameMaterial($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateGroup(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialRepository->checkRoleUpdate($result);
        if($check != 0){
            return $this->materialRepository->updateGroupMaterial($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function delete($id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialRepository->checkRoleDelete($result);
        if($check != 0){
            return $this->materialRepository->deleteMaterial($id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function exportExcel()
    {
        return Excel::download(new MaterialExport,'material.xlsx');
    }
}
