<?php

namespace App\Http\Controllers;

use App\MaterialAction;
use App\MaterialDetail;
use Illuminate\Http\Request;

class MaterialDetailController extends Controller
{
    public function index()
    {
        $materialDetails = MaterialDetail::orderBy('id','desc')->paginate(10);
        return view('materialdetail.index',compact('materialDetails'));
    }

    public function store(Request $request)
    {
        $materialDetail = new MaterialDetail();
        $materialDetail->name = $request->name;
        $materialDetail->save();
        return redirect(route('material_detail.index'));
    }

    public function update(Request $request,$id)
    {
       $materialDetail = MaterialDetail::find($id);
       $materialDetail->name = $request->name;
       $materialDetail->save();
       return redirect(route('material_detail.index'));
    }

    public function delete($id)
    {
        $materialAction = MaterialAction::where('id_material_detail',$id)->delete();
        $materialDetail = MaterialDetail::find($id)->delete();
        return redirect(route('material_detail.index'));
    }

    public function search(Request $request)
    {
        $temp = $request->nameSearch;
        $materialDetails = MaterialDetail::where('name','LIKE',"%{$temp}%")->get();
        return view('materialdetail.search',compact('materialDetails'));
    }
}
