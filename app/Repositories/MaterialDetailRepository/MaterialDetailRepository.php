<?php
namespace App\Repositories\MaterialDetailRepository;

use App\Http\Controllers\Controller;
use App\Repositories\MaterialDetailRepository\IMaterialDetailRepository;
use App\MaterialAction;
use App\MaterialDetail;

class MaterialDetailRepository extends Controller implements IMaterialDetailRepository{

    public function showMaterialDetail()
    {
        $materialDetails = MaterialDetail::orderBy('id','desc')->paginate(10);
        return view('materialdetail.index',compact('materialDetails'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'nameAdd.required' => 'Không để trống tên nvl',
            'nameAdd.min' => 'Tên nvl nhiều hơn 3 ký tự',
            'nameAdd.max' => 'Tên nvl giới hạn 30 ký tự',
            'nameAdd.unique' => 'Tên nvl đã tồn tại trong hệ thống'
        ];

        $req->validate(
            [
                'nameAdd' => 'required|min:3|max:30|unique:material_details,name',
            ],
            $messeages
        );
    }

    public function addMaterialDetail($request)
    {
        $materialDetail = new MaterialDetail();
        $materialDetail->name = $request->name;
        $materialDetail->save();
        return redirect(route('material_detail.index'));
    }

    public function validatorRequestSearch($req){
        $messeages = [
            'nameSearch.required' => 'Không để trống tên nvl cần search',
        ];

        $req->validate(
            [
                'nameSearch' => 'required',
            ],
            $messeages
        );
    }

    public function searchMaterialDetail($request)
    {
        $temp = $request->nameSearch;
        $materialDetails = MaterialDetail::where('name','LIKE',"%{$temp}%")->get();
        return view('materialdetail.search',compact('materialDetails'));
    }

    public function validatorRequestUpdate($req){
        $messeages = [
            'name.required' => 'Không để trống tên nvl',
            'name.min' => 'Tên nvl nhiều hơn 3 ký tự',
            'name.max' => 'Tên nvl giới hạn 30 ký tự',
            'name.unique' => 'Tên nvl đã tồn tại trong hệ thống'
        ];

        $req->validate(
            [
                'name' => 'required|min:3|max:30|unique:material_details,name',
            ],
            $messeages
        );
    }
    public function updateMaterialDetail($request,$id)
    {
        $materialDetail = MaterialDetail::find($id);
        $materialDetail->name = $request->name;
        $materialDetail->save();
        return redirect(route('material_detail.index'));
    }

    public function deleteMaterialDetail($id)
    {
        $materialAction = MaterialAction::where('id_material_detail',$id)->delete();
        $materialDetail = MaterialDetail::find($id)->delete();
        return redirect(route('material_detail.index'));
    }
}
