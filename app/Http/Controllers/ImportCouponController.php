<?php

namespace App\Http\Controllers;

use App\Repositories\ImportCouponRepository\IImportCouponRepository;
use Illuminate\Http\Request;

class ImportCouponController extends Controller
{
    private $importcouponRepository;

    public function __construct(IImportCouponRepository $importcouponRepository)
    {
        $this->importcouponRepository = $importcouponRepository;
    }

    public function index()
    {
        return $this->importcouponRepository->showIndex();
    }

    public function viewImport()
    {
        return $this->importcouponRepository->showViewImport();
    }

    public function import(Request $request)
    {
        return $this->importcouponRepository->import($request);
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
