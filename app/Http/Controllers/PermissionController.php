<?php

namespace App\Http\Controllers;
use App\Permission;
use Illuminate\Http\Request;
use Redirect;
class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::all();

        return view('permission.index', compact('permissions'));
    }
    public function viewstore(){

        return view('permission.store');
    }

    public function store(Request $req){
        dd($req);
        $input = $req->all();

        $permission = Permission::create($input);
        
        if($permission){
            return Redirect::to('/permission');
        }

    }
}
