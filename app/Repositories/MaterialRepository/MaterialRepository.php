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
        $materials = Material::with('groupMenu')->paginate(3);
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
        $req->validate(['nameMaterial' => 'unique:materials,name'],
            ['nameMaterial.unique' => 'Tên vừa thay đổi đã tồn tại trong hệ thống']);
    }

    public function searchMaterial($request)
    {
        $name = $request->nameSearch;
        $materials = Material::where('name','LIKE',"%{$name}%")->get();
        $groupMenus = $this->getCategoryDish();
        return view('material.search',compact('materials','groupMenus'));
    }
    public function updateNameMaterial($request, $id)
    {
        Material::where('id',$id)->update(['name' => $request->nameMaterial]);
        return redirect(route('material.index'));
    }
    public function updateGroupMaterial($request, $id)
    {
        Material::where('id',$id)->update(['id_groupmenu' => $request->idGroupMenu]);
        return redirect(route('material.index'));
    }
    public function deleteMaterial($id)
    {
        $material = Material::find($id)->delete();
        return redirect(route('material.index'));
    }
}
