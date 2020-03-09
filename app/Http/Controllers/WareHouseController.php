<?php

namespace App\Http\Controllers;

use App\MaterialDetail;
use App\Supplier;
use App\Unit;
use App\WareHouse;
use App\WareHouseDetail;
use Illuminate\Http\Request;
use Excel;
use App\Imports\WareHouseDetailImport;

class WareHouseController extends Controller
{
    public function index()
    {
        $imp = WareHouse::with('detailWarehouse','goods','unit')->get();
        dd($imp);
        return view('warehouse.index',compact('imp'));
    }

    public function viewImport()
    {
        $suppliers = Supplier::all();
        $goods = MaterialDetail::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('warehouse.import',compact('suppliers','goods','units'));
    }

    public function import(Request $request)
    {
        $import = new WareHouse();
        $import->id_supplier = $request->supplier;
        //dd($import);
        $import->save();

        $a = $import->first('id');
        $import_detail = new WareHouseDetail();
        $import_detail->id_import = $a->id;
        $import_detail->id_good = $request->good;
        $import_detail->qty = $request->qty;
        $import_detail->id_unit = $request->unit;
        $import_detail->price = $request->price;
        $import_detail->save();

    }

    public function testExcel()
    {
        $res = Excel::toCollection(new WareHouseDetailImport, 'test.xlsx');
        dd($res);
        foreach ($res as $key => $value) {
            $imp = WareHouseDetail::create($value);
        }
    }
}
