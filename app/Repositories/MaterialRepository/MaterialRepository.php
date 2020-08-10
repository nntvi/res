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

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_TEN_MON_CT"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "TAO_TEN_MON_CT"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_TEN_MON_CT"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleDelete($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XOA_TEN_MON_CT"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getCategoryDish()
    {
        $groupMenu = GroupMenu::where('status','1')->get();
        return $groupMenu;
    }

    public function showMaterial()
    {
        $materials = Material::with('groupMenu','materialAction.materialDetail')->where('status','1')->orderBy('id','desc')->get();
        $groupMenus = $this->getCategoryDish();
        return view('material.index',compact('materials','groupMenus'));
    }

    public function validatorRequestStore($req){
        $req->validate(
            [ 'name' => 'status_material|regex:/^[\pL\s]+$/u'],
            [   'name.status_material' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống',
                'name.regex' => 'Tên món ăn không được là số'
            ]
        );
    }

    public function addMaterial($request)
    {
        $material = new Material();
        $material->name = $request->name;
        $material->id_groupmenu = $request->idGroupMenu;
        $material->status = '1';
        $material->save();
        return redirect(route('material.index'))->withSuccess('Thêm tên món thành công');
    }

    public function validatorRequestUpdate($req){
        $req->validate(
            ['nameMaterial' => 'unique:materials,name'],
            ['nameMaterial.unique' => 'Tên vừa thay đổi đã tồn tại trong hệ thống']);
    }

    public function updateNameMaterial($request, $id)
    {
        Material::where('id',$id)->update(['name' => $request->nameMaterial]);
        Dishes::where('id_groupnvl',$id)->update(['name' => $request->nameMaterial]);
        return redirect(route('material.index'))->with('info','Cập nhật nhóm thực đơn thành công');
    }

    public function addCook($arrayMaterialDetails,$tempCook)
    {
        foreach ($arrayMaterialDetails as $key => $value) {
            $warehousecook = new WarehouseCook();
            $warehousecook->cook = $tempCook;
            $warehousecook->id_material_detail = $value->id_material_detail;
            $warehousecook->qty = 0.00;
            $warehousecook->status = '0';
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
        Dishes::where('id_groupnvl',$id)->update(['id_groupmenu' => $request->idGroupMenu]);
        return redirect(route('material.index'))->with('info','Cập nhật nhóm thực đơn thành công');
    }

    public function deleteMaterial($id)
    {
        Dishes::where('id_groupnvl',$id)->update(['stt' => '0']);
        MaterialAction::where('id_groupnvl',$id)->delete();
        Material::where('id',$id)->update(['status' => '0']);
        return redirect(route('material.index'))->withSuccess('Xóa tên món thành công');
    }
}
