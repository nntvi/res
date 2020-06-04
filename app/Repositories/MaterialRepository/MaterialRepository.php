<?php
namespace App\Repositories\MaterialRepository;

use App\Dishes;
use App\GroupMenu;
use App\Http\Controllers\Controller;
use App\Repositories\MaterialRepository\IMaterialRepository;
use App\Material;
use App\MaterialAction;
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
        $materials = Material::with('groupMenu','materialAction.materialDetail')->orderBy('id','desc')->paginate(8);
        $groupMenus = $this->getCategoryDish();
        return view('material.index',compact('materials','groupMenus'));
    }

    public function validatorRequestStore($req){
        $req->validate(
            [ 'name' => 'unique:materials,name'],
            ['name.unique' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống'],
        );
    }

    public function addMaterial($request)
    {
        $material = new Material();
        $material->name = $request->name;
        $material->id_groupmenu = $request->idGroupMenu;
        $material->save();
        return redirect(route('material.index'))->withSuccess('Thêm tên món thành công');
    }

    public function validatorRequestUpdate($req){
        $req->validate(
            ['nameMaterial' => 'unique:materials,name'],
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
        return redirect(route('material.index'))->with('info','Cập nhật nhóm thực đơn thành công');
    }

    public function addCook($arrayMaterialDetails,$tempCook)
    {
        foreach ($arrayMaterialDetails as $key => $value) {
            $warehousecook = new WarehouseCook();
            $warehousecook->cook = $tempCook;
            $warehousecook->id_material_detail = $value->id_material_detail;
            $warehousecook->qty = 0.00;
            $warehousecook->id_unit = $value->id_dvt;
            $warehousecook->save();
        }
    }

    public function checkCook($idcook,$tempCook,$id)
    {
        if($idcook->groupMenu->id_cook != $tempCook){
            // lấy ra nvl bếp mới
            $nvlInNewCook = WarehouseCook::where('cook',$tempCook)->get('id_material_detail');
            // lấy ra nvl tạo nên món đó mà ko có trong bếp mới
            $arrayMaterialDetails = MaterialAction::where('id_groupnvl',$id)
                                    ->whereNotIn('id_material_detail',$nvlInNewCook)->get();
            $this->addCook($arrayMaterialDetails,$tempCook);
        }
    }

    public function updateGroupMaterial($request, $id)
    {
        // lấy ra nvl tạo thành món đó
        $arrayIdDetailMaterials = MaterialAction::where('id_groupnvl',$id)->get('id_material_detail');
        // tìm xem cook nào thực hiện món đó
        $idcook = Material::where('id',$id)->with('groupMenu')->first(); // ($idcook->groupMenu->id_cook)
        // lấy id danh mục mới thay đổi
        $newGroupMenu = $request->idGroupMenu;
        // kiểm tra có cùng thuộc bếp hay ko
        $tempCook = GroupMenu::where('id',$newGroupMenu)->value('id_cook');
        // nếu khác, phải thêm nvl tạo thành món đó vào bếp vừa thay đổi
        $this->checkCook($idcook,$tempCook,$id);
        Material::where('id',$id)->update(['id_groupmenu' => $request->idGroupMenu]);
        return redirect(route('material.index'))->with('infor','Cập nhật nhóm thực đơn thành công');
    }
    public function deleteMaterial($id)
    {
        Material::find($id)->delete();
        Dishes::where('id_groupnvl',$id)->delete();
        return redirect(route('material.index'))->withSuccess('Xóa tên món thành công');
    }
}
