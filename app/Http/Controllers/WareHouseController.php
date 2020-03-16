<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Excel;
use App\Imports\WareHouseDetailImport;
<<<<<<< HEAD
use App\Inventory;
=======
use App\Repositories\WarehouseRepository\IWarehouseRepository;
>>>>>>> f14c71721dd67eb27b808c9a9fb48a742c686946

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
<<<<<<< HEAD
        $count = count($request->id_material);
        $sum = 0;
        for ($i=0; $i < $count; $i++) {
            $detail_warehouse = new WareHouseDetail();
            $inventory = new Inventory();
            $detail_warehouse->code_import = $request->code;
            $detail_warehouse->id_material_detail = $request->id_material[$i];
            $detail_warehouse->qty = $request->qty[$i];
            $detail_warehouse->id_unit = $request->id_unit[$i];
            $detail_warehouse->price = $request->price[$i];
            //dd($detail_warehouse);
            $sum+= $request->qty[$i] * $request->price[$i];
            $detail_warehouse->save();
            $inventory->save();
        }

        $warehouse = new WareHouse();
        $warehouse->code = $request->code;
        $warehouse->id_supplier = $request->supplier;
        $warehouse->note = $request->note;
        $warehouse->total = $sum;
        $warehouse->save();
        return redirect(route('warehouse.index'));
=======
       return $this->warehouseRepository->importWarehouse($request);
>>>>>>> f14c71721dd67eb27b808c9a9fb48a742c686946
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

<<<<<<< HEAD
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
=======

>>>>>>> f14c71721dd67eb27b808c9a9fb48a742c686946
}
