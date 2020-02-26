<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;
class ApiController extends Controller
{



    public function index($id)
    {
        $tables = Table::where('id_area',$id)->get();
        //dd($tables);
        if (is_null($tables)) {
            return response()->json([ "message" => "Record not found"], 404);
        }

        return response()->json($tables, 200);
    }
}
