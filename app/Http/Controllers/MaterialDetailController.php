<?php

namespace App\Http\Controllers;

use App\MaterialAction;
use App\MaterialDetail;
use App\Repositories\MaterialDetailRepository\IMaterialDetailRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MaterialDetailExport;
use App\Helper\ICheckAction;
class MaterialDetailController extends Controller
{
    private $materialDetailRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction,IMaterialDetailRepository $materialDetailRepository)
    {
        $this->checkAction = $checkAction;
        $this->materialDetailRepository = $materialDetailRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialDetailRepository->checkRoleIndex($result);
        if($check != 0){
            $price = $this->materialDetailRepository->getPrice();
            $materialDetails = $this->materialDetailRepository->getMaterialDetail();
            $types = $this->materialDetailRepository->getTypeMaterial();
            $units = $this->materialDetailRepository->getUnit();
            return view('materialdetail.index',compact('materialDetails','types','units','price'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function store(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialDetailRepository->checkRoleStore($result);
        if($check != 0){
            $this->materialDetailRepository->validatorName($request);
            return $this->materialDetailRepository->addMaterialDetail($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateName(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialDetailRepository->checkRoleUpdate($result);
        if($check != 0){
            $this->materialDetailRepository->validatorName($request);
            return  $this->materialDetailRepository->updateNameMaterialDetail($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateType(Request $request,$id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialDetailRepository->checkRoleUpdate($result);
        if($check != 0){
            return $this->materialDetailRepository->updateTypeMaterialDetail($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function delete($id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->materialDetailRepository->checkRoleDelete($result);
        if($check != 0){
            return $this->materialDetailRepository->deleteMaterialDetail($id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function exportExcel()
    {
        return Excel::download(new MaterialDetailExport,'nvl.xlsx');
    }
}
