<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
       $materials = Material::all();
       return view('material.index',compact('materials'));
    }
    public function store(Request $request)
    {
        $material = new Material();
        $material->name = $request->name;
        $material->save();
        return redirect(route('material.index'));
    }
    public function update(Request $request, $id)
    {
        $material = Material::find($id);
        $material->name = $request->name;
        $material->save();
        return redirect(route('material.index'));
    }

    public function delete($id)
    {
       $material = Material::find($id)->delete();
       return redirect(route('material.index'));
    }
}
