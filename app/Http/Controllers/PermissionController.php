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

    public function getEdit($id)
    {
        $permission = Permission::find($id);
        return view('permission.update',['permission' => $permission]);
    }

    public function postEdit(Request $req, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $req->name;
        $permission->save();

        return redirect('permission');
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect('permission');
    }
}
