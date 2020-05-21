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

class WareHouseController extends Controller
{
    private $warehouseRepository;

    public function __construct(IWarehouseRepository $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    public function index()
    {
        return $this->warehouseRepository->showIndex();
    }
    public function updateLimitStock(Request $request, $id)
    {
        return $this->warehouseRepository->updateLimitStockWarehouse($request,$id);
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
