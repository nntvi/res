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
        $listImports = WareHouse::with('supplier')->get();
        //dd($listImports);
        return view('warehouse.index',compact('listImports'));
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
        return redirect(route('warehouse.index'));
    }

    public function getDetail($code)
    {
        $detailImports = WareHouseDetail::where('code_import',$code)->with('materialDetail','unit')->get();
        $units = Unit::orderBy('name')->get();
        return view('warehouse.detail',compact('detailImports','code','units'));
    }

    public function updateDetail(Request $request, $id)
    {
        $detailImport = WareHouseDetail::find($id);
        $code = $detailImport->code_import;

        $detailImport->qty = $request->qty;
        $detailImport->id_unit = $request->id_unit;
        $detailImport->price = $request->price;
        $detailImport->save();

        $check = WareHouseDetail::where('code_import',$code)->get();
        $sum = 0;
        foreach ($check as $key => $value) {
            $sum += $value->qty * $value->price;
        }
        $import = WareHouse::where('code',$code)->update(['total' => $sum]);

        return redirect(route('warehouse.detail',['code' => $code]));
    }

    public function printDetail($code)
    {
        $import = WareHouse::where('code',$code)->with('supplier')->first();
        $detailImports = WareHouseDetail::where('code_import',$code)->with('materialDetail','unit')->get();
        return view('warehouse.print',compact('import','detailImports'));
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
