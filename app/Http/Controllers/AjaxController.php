<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\Supplier;
use App\Unit;
use App\WareHouseDetail;
use App\MaterialDetail;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getType($id)
    {
        if($id == 1){
            $cooks = CookArea::all();
            return response()->json($cooks, 200);

        }
        else if($id == 3){
            $suppliers = Supplier::all();
            return response()->json($suppliers, 200);
        }
        else if($id == 2){
            $data = array();
            $data = [
                'id' => 0,
                'name' => 'Hủy'
            ];
            return response()->json($data, 200);
        }
    }

    public function searchMaterialExport($name)
    {
        $detailMaterial = WareHouseDetail::with('materialDetail','unit')
                            ->whereHas('materialDetail', function ($query)  use($name) {
                                $query->where('name', 'LIKE', $name);
                        })->get();
        $units = Unit::all();
        $data = [
            'detailMaterial' => $detailMaterial,
            'units' => $units
        ];
        return response()->json($data, 200);
    }

    public function getSearchMaterialDetail($name)
    {
        $materialDetails = MaterialDetail::where('name','LIKE',"%{$name}%")->get();
        if(is_null($materialDetails)){
            return response()->json([ "message" => "Record not found"], 404);
        }
        return response()->json($materialDetails,200);
    }
}
