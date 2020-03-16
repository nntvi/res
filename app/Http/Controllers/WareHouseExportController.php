<?php

namespace App\Http\Controllers;

use App\TypeExport;
use App\WareHouseDetail;
use App\WarehouseExport;
use App\WarehouseExportDetail;
use Illuminate\Http\Request;

class WareHouseExportController extends Controller
{
    public function index()
    {
        $warehouseexports = WarehouseExport::with('typeExport')->get();
        return view('warehouseexport.index',compact('warehouseexports'));
    }

    public function viewExport()
    {
        $kinds = TypeExport::all();
        $goods = WareHouseDetail::with('materialDetail','unit')->get();
        return view('warehouseexport.export',compact('kinds','goods'));
    }

    public function export(Request $request)
    {
        $count = count($request->id_unit);
        for ($i=0; $i < $count; $i++) {
            $detail_export = new WarehouseExportDetail();
            $detail_export->code_export = $request->code;
            $detail_export->id_material_detail = $request->id_material_detail[$i];
            $detail_export->qty = $request->qtyExport[$i];
            $detail_export->id_unit = $request->id_unit[$i];
            $detail_export->save();
        }
        $warehouse_export = new WarehouseExport();
        $warehouse_export->code = $request->code;
        $warehouse_export->id_type = $request->id_kind;
        $warehouse_export->id_object = $request->type_object;
        $warehouse_export->note = $request->node;
        $warehouse_export->save();
    }

    public function getDetail($code)
    {
        $detailExports = WarehouseExportDetail::where('code_export',$code)->with('materialDetail','unit')->get();
        //dd($detailExports);
        return view('warehouseexport.detail',compact('detailExports','code'));
    }

    public function printDetail($code)
    {
        $detailExports = WarehouseExportDetail::where('code_export',$code)->with('materialDetail','unit')->get();
        $export = WarehouseExport::where('code',$code)->with('typeExport')->first();
        return view('warehouseexport.print',compact('detailExports','export'));
    }
}
