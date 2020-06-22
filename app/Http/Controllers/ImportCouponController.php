<?php

namespace App\Http\Controllers;

use App\ImportCoupon;
use Illuminate\Http\Request;
use App\Repositories\ImportCouponRepository\IImportCouponRepository;

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
        $this->importcouponRepository->validateCreatImportCoupon($request);
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

    public function search(Request $request)
    {
        $search = $request->searchImC;
        $count = ImportCoupon::selectRaw('count(code) as qty')->where('code','LIKE',"%{$search}%")->orWhere('total','LIKE',"%{$search}%")->value('qty');
        $listImports = ImportCoupon::where('code','LIKE',"%{$search}%")->orWhere('total','LIKE',"%{$search}")->with('supplier','detailImportCoupon')->get();
        return view('importcoupon.search',compact('listImports','count'));
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
