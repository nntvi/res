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
            'name.required' => 'Không để trống tên khu vực',
            'name.min' => 'Tên khu vực nhiều hơn 3 ký tự',
            'name.max' => 'Tên khu vực giới hạn 30 ký tự',
            'name.unique' => 'Tên khu vực đã tồn tại trong hệ thống'
        ];

        $req->validate(
            [
                'name' => 'required|min:3|max:30|unique:areas,name',
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
}
