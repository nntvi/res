<?php

namespace App\Http\Controllers;

use App\MaterialDetail;
use App\Supplier;
use App\Unit;
use App\WareHouse;
use App\WareHouseDetail;
use Illuminate\Http\Request;
//use Excel;
//use App\Imports\WareHouseDetailImport;

class WareHouseController extends Controller
{
    public function index()
    {
        $imp = WareHouse::all();
        return view('warehouse.index',compact('imp'));
    }

    public function viewImport()
    {
        $suppliers = Supplier::all();
        $material_details = MaterialDetail::orderBy('name')->get();
        $units = Unit::all();
        return view('warehouse.import',compact('suppliers','units','material_details'));
    }

    public function import(Request $request)
    {
        $count = count($request->id_material);
        $sum = 0;
        for ($i=0; $i < $count; $i++) {
            $detail_warehouse = new WareHouseDetail();
            $detail_warehouse->code_import = $request->code;
            $detail_warehouse->id_material_detail = $request->id_material[$i];
            $detail_warehouse->qty = $request->qty[$i];
            $detail_warehouse->id_unit = $request->id_unit[$i];
            $detail_warehouse->price = $request->price[$i];
            //dd($detail_warehouse);
            $sum+= $request->qty[$i] * $request->price[$i];
            $detail_warehouse->save();
        }

        $warehouse = new WareHouse();
        $warehouse->code = $request->code;
        $warehouse->id_supplier = $request->supplier;
        $warehouse->note = $request->note;
        $warehouse->total = $sum;
        $warehouse->save();

    }



    // public function import(Request $request)
    // {
    //     $import = new WareHouse();
    //     $import->id_supplier = $request->supplier;
    //     //dd($import);
    //     $import->save();

    //     $a = $import->first('id');
    //     $import_detail = new WareHouseDetail();
    //     $import_detail->id_import = $a->id;
    //     $import_detail->id_good = $request->good;
    //     $import_detail->qty = $request->qty;
    //     $import_detail->id_unit = $request->unit;
    //     $import_detail->price = $request->price;
    //     $import_detail->save();

    // }

    // public function testExcel()
    // {
    //     $res = Excel::toCollection(new WareHouseDetailImport, 'test.xlsx');
    //     dd($res);
    //     foreach ($res as $key => $value) {
    //         $imp = WareHouseDetail::create($value);
    //     }
    // }
}
