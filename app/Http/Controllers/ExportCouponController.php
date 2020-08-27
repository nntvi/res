<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\ExportCoupon;
use App\TypeMaterial;
use App\Helper\ICheckAction;
use Illuminate\Http\Request;
use App\Repositories\ExportCouponRepository\IExportCouponRepository;

class ExportCouponController extends Controller
{
    private $exportcouponRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IExportCouponRepository $exportcouponRepository)
    {
        $this->checkAction = $checkAction;
        $this->exportcouponRepository = $exportcouponRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->exportcouponRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->exportcouponRepository->showIndex();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function viewExport(Request $request)
    {
        return $this->exportcouponRepository->showViewExport($request);
    }

    public function exportTemp(Request $request)
    {
        $code = $request->code;
        $idKind = $request->id_kind;
        $idObject = $request->type_object;
        $nameCook = CookArea::where('id',$request->type_object)->value('name');
        $note = $request->note;
        $arr = $this->exportcouponRepository->createTempMaterialToExport($request->idMaterialDetail,$request->type_object);
        return view('warehouseexport.exportcook2',compact('code','idKind','idObject','nameCook','note','arr'));
    }

    public function export(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->exportcouponRepository->checkRoleStore($result);
        if($check != 0){
            $this->exportcouponRepository->validateExport($request);
            return $this->exportcouponRepository->exportMaterial($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }
    public function exportSupplier(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->exportcouponRepository->checkRoleStore($result);
        if($check != 0){
            return $this->exportcouponRepository->exportSupplier($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function getDetail($id)
    {
        return $this->exportcouponRepository->getDetailExport($id);
    }

    public function getDetailExportSupplier($id)
    {
        return $this->exportcouponRepository->getDetailExportSupplier($id);
    }
    public function printDetail($id)
    {
        return $this->exportcouponRepository->printDetailExport($id);
    }

    public function viewDestroyWarehouse()
    {
        $code = $this->exportcouponRepository->createCode("XHK");
        $types = TypeMaterial::all();
        return view('warehouseexport.exportdestroy',compact('code','types'));
    }

    public function destroyWarehouse(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->exportcouponRepository->checkRoleStore($result);
        if($check != 0){
            return $this->exportcouponRepository->destroyWarehouse($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function viewDestroyWarehouseCook($id)
    {
        return $this->exportcouponRepository->viewDestroyCook($id);
    }

    public function destroyWarehouseCook(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->exportcouponRepository->checkRoleStore($result);
        if($check != 0){
            return $this->exportcouponRepository->destroyCook($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

}
