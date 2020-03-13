<?php

namespace App\Http\Controllers;

use App\TypeExport;
use App\WareHouseDetail;
use Illuminate\Http\Request;

class WareHouseExportController extends Controller
{
    public function index()
    {
        return view('warehouseexport.index');
    }

    public function viewExport()
    {
        $kinds = TypeExport::all();
        $goods = WareHouseDetail::with('materialDetail','unit')->get();
        return view('warehouseexport.export',compact('kinds','goods'));
    }
}
