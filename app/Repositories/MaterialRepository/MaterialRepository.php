<?php
namespace App\Repositories\MaterialRepository;

use App\GroupMenu;
use App\Http\Controllers\Controller;
use App\Repositories\MaterialRepository\IMaterialRepository;
use App\Material;
use App\WareHouse;
use App\WarehouseCook;

class MaterialRepository extends Controller implements IMaterialRepository{

    public function getCategoryDish()
    {
        $groupMenu = GroupMenu::all();
        return $groupMenu;
    }
    public function showMaterial()
    {
        $materials = Material::with('groupMenu')->get();
        $groupMenus = $this->getCategoryDish();
        return view('material.index',compact('materials','groupMenus'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'name.required' => 'Không để trống tên nhóm thực đơn',
            'name.min' => 'Tên thực đơn nhiều hơn 3 ký tự',
            'name.max' => 'Tên thực đơn giới hạn 30 ký tự',
            'name.unique' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống',
            'idGroupMenu.required' => 'Vui lòng chọn danh mục món ăn'
        ];
        $req->validate(
            [
                'name' => 'required|min:3|max:30|unique:groupmenu,name',
                'idGroupMenu' => 'required'
            ],
            $messeages
        );
    }

    public function addMaterial($request)
    {
        $material = new Material();
        $material->name = $request->name;
        $material->id_groupmenu = $request->idGroupMenu;
        $material->save();
        return redirect(route('material.index'));
    }

    public function validatorRequestUpdate($req){
        $messeages = [
            'nameMaterial.required' => 'Không để trống tên nhóm thực đơn',
            'nameMaterial.min' => 'Tên thực đơn nhiều hơn 3 ký tự',
            'nameMaterial.max' => 'Tên thực đơn giới hạn 30 ký tự',
        ];
        $req->validate(
            [
                'nameMaterial' => 'required|min:3|max:30',
            ],
            $messeages
        );
    }

    public function updateMaterial($request,$id)
    {
        $material = Material::find($id);
        $material->name = $request->nameMaterial;
        $material->id_groupmenu = $request->groupMenu;
        $material->save();
        return redirect(route('material.index'));
    }

    public function deleteMaterial($id)
    {
        $material = Material::find($id)->delete();
        return redirect(route('material.index'));
    }
}
