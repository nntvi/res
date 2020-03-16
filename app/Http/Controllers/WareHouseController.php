<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Excel;
use App\Imports\WareHouseDetailImport;
use App\Repositories\WarehouseRepository\IWarehouseRepository;

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

    public function viewImport()
    {
        return $this->warehouseRepository->showViewImport();
    }

    public function import(Request $request)
    {
       return $this->warehouseRepository->importWarehouse($request);
    }

    public function getDetail($code)
    {
        $detailImports = $this->warehouseRepository->getDetailWarehouseByCode($code);
        $units = $this->warehouseRepository->getUnit();
        return view('warehouse.detail',compact('detailImports','code','units'));
    }

    public function updateDetail(Request $request, $id)
    {
        return $this->warehouseRepository->updateDetailWarehouse($request,$id);
    }

    public function printDetail($code)
    {
        return $this->warehouseRepository->printDetailByCode($code);
    }


}
