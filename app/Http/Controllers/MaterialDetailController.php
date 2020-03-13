<?php

namespace App\Http\Controllers;

use App\MaterialAction;
use App\MaterialDetail;
use App\Repositories\MaterialDetailRepository\IMaterialDetailRepository;
use Illuminate\Http\Request;

class MaterialDetailController extends Controller
{
    private $materialDetailRepository;

    public function __construct(IMaterialDetailRepository $materialDetailRepository)
    {
        $this->materialDetailRepository = $materialDetailRepository;
    }

    public function index()
    {
        return $this->materialDetailRepository->showMaterialDetail();
    }

    public function store(Request $request)
    {
        $this->materialDetailRepository->validatorRequestStore($request);
        return $this->materialDetailRepository->addMaterialDetail($request);
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
