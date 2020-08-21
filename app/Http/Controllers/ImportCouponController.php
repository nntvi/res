<?php

namespace App\Http\Controllers;

use App\ImportCoupon;
use App\Plan;
use Illuminate\Http\Request;
use App\Repositories\ImportCouponRepository\IImportCouponRepository;
use App\Helper\ICheckAction;

class ImportCouponController extends Controller
{
    private $importcouponRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IImportCouponRepository $importcouponRepository)
    {
        $this->checkAction = $checkAction;
        $this->importcouponRepository = $importcouponRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->importcouponRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->importcouponRepository->showIndex();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function gettype(Request $request)
    {
        $type = $request->typeImp;
        if($type == '1'){
           return $this->viewImport();
        }else{
            return $this->importcouponRepository->showViewImportPlan();
        }
    }

    public function viewImport()
    {
        return $this->importcouponRepository->showViewImport();
    }

    public function import(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->importcouponRepository->checkRoleStore($result);
        if($check != 0){
            $this->importcouponRepository->validateCreatImportCoupon($request);
            return $this->importcouponRepository->import($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function importPlan(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->importcouponRepository->checkRoleStore($result);
        if($check != 0){
            $this->importcouponRepository->validateCreatImportCouponPlan($request);
            Plan::where('id',$request->idPlan)->update(['status' => '1']);
            return $this->importcouponRepository->import($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }
    public function getDetail($id)
    {
        return $this->importcouponRepository->getDetailImportCouponById($id);
    }

    public function updateDetail(Request $request, $id)
    {
        return $this->importcouponRepository->updateDetailImportCoupon($request,$id);
    }

    public function printDetail($id)
    {
        return $this->importcouponRepository->printDetailByCode($id);
    }

    // public function substractMaterial()
    // {

    // }
    // public function testExcel()
    // {
    //     $res = Excel::toArray(new WareHouseDetailImport, 'test.xlsx');
    //     //dd($res);
    //     foreach ($res as $key => $round) {
    //         foreach ($round as $key => $value) {
    //             $imp = WareHouseDetail::create($value);
    //         }
    //     }
    // }
}
