<?php

namespace App\Http\Controllers;

use App\Dishes;
use Illuminate\Http\Request;
use App\Table;
use App\MaterialDetail;
class AjaxController extends Controller
{
    public function getTable($id)
    {
        $tables = Table::where('id_area',$id)->get();
        if (is_null($tables)) {
            return response()->json([ "message" => "Record not found"], 404);
        }

        return response()->json($tables, 200);
    }

    public function getDish($id)
    {
        $dishes = Dishes::where('id_groupmenu',$id)->get();
        if(is_null($dishes)){
            return response()->json([ "message" => "Record not found"], 404);
        }
        return response()->json($dishes,200);
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
