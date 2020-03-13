<?php

namespace App\Http\Controllers;

use App\Material;
use App\MaterialAction;
use App\MaterialDetail;
use App\Unit;
use Illuminate\Http\Request;

class MaterialActionController extends Controller
{
    public function index()
    {
        $materials = Material::with('materialAction.materialDetail')->get();
        return view('materialaction.index',compact('materials'));
    }

    public function viewStore($id)
    {
        $material = Material::where('id',$id)->first();
        $units = Unit::orderBy('name','asc')->get();
        $materialDetails = MaterialDetail::orderBy('name','asc')->get();
        return view('materialaction.store',compact('material','units','materialDetails'));
    }
    public function store(Request $request,$id)
    {
        $count = count($request->id_material);
        for ($i=0; $i < $count; $i++) {
            $materialDetail = new MaterialAction();
            $materialDetail->id_groupnvl = $request->id_groupnvl;
            $materialDetail->id_material_detail = $request->id_material[$i];
            $materialDetail->id_dvt = $request->id_unit[$i];
            $materialDetail->qty = $request->qty[$i];
            $materialDetail->save();
        }
        return redirect(route('material_action.index'));
    }

    public function showMoreDetail($id)
    {
        $materials = Material::where('id',$id)->with('materialAction.materialDetail','materialAction.unit')->get();
        return view('materialaction.detail',compact('materials'));
    }

    public function viewUpdate($id)
    {
        $materialAction = MaterialAction::where('id',$id)->with('materialDetail','unit','material')->get();
        //dd($materialAction);
        $units = Unit::all();
        return view('materialaction.update',compact('materialAction','units'));
    }

    public function update(Request $request, $id)
    {
        $mat_detail = MaterialAction::find($id);
        $mat_detail->id_dvt = $request->id_dvt;
        $mat_detail->qty = $request->qty;
        $mat_detail->save();
        return redirect(route('material_action.detail',['id' => $mat_detail->id_groupnvl]));
    }

    public function delete($id)
    {
        $mat_detail = MaterialAction::find($id);
        $id_groupnvl = $mat_detail->id_groupnvl;
        $mat_detail->delete();
        return redirect(route('material_action.detail',['id' => $id_groupnvl]));
    }
}
