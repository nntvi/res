<?php

namespace App\Http\Controllers;

use App\ExportCouponDetail;
use App\Exports\ReportWarehouse;
use App\ImportCouponDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WareHouseDetailImport;
use App\Repositories\WarehouseRepository\IWarehouseRepository;
use App\WareHouse;
use App\Helper\ICheckAction;

class WareHouseController extends Controller
{
    private $warehouseRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IWarehouseRepository $warehouseRepository)
    {
        $this->checkAction = $checkAction;
        $this->warehouseRepository = $warehouseRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->warehouseRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->warehouseRepository->showIndex();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function updateLimitStock(Request $request, $id)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->warehouseRepository->checkRoleUpdate($result);
        if($check != 0){
            return $this->warehouseRepository->updateLimitStockWarehouse($request,$id);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function report(Request $request)
    {
        return $this->warehouseRepository->reportWarehouse($request);
    }

    public function getDetailReport($id,$dateStart,$dateEnd)
    {
        return $this->warehouseRepository->getDetailReport($id,$dateStart,$dateEnd);
    }

    public function exportExcel($dateStart,$dateEnd)
    {
        return Excel::download(new ReportWarehouse($dateStart,$dateEnd),'reportwarehouse.xlsx');
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
