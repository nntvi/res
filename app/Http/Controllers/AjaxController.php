<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\Supplier;
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
    public function searchDetailWarehouse($name)
    {


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
