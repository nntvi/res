<?php

namespace App\Http\Controllers;

use App\ExportCouponDetail;
use App\ImportCouponDetail;
use Illuminate\Http\Request;
use Excel;
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

    public function report(Request $request)
    {
        return $this->warehouseRepository->reportWarehouse($request);
    }

    public function getDetailReport($id,$dateStart,$dateEnd)
    {
        return $this->warehouseRepository->getDetailReport($id,$dateStart,$dateEnd);
    }
}
