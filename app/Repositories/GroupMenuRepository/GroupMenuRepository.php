<?php
namespace App\Repositories\GroupMenuRepository;

use App\Http\Controllers\Controller;
use App\Repositories\GroupMenuRepository\IGroupMenuRepository;
use App\GroupMenu;
use App\CookArea;
use App\Dishes;
use App\Material;
use App\MaterialAction;
use App\WarehouseCook;

class GroupMenuRepository extends Controller implements IGroupMenuRepository{
    public function getAllGroupMenu()
    {
        $groupmenus = GroupMenu::with('cookArea')->paginate(5);
        $cooks = CookArea::all();
        $cook_active = array();
        foreach ($cooks as $key => $cook) {
            if($cook->status != '0'){
                $cook_active[] = $cook;
            }
        }
        return view('groupmenu.index',compact('groupmenus','cook_active'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'name.required' => 'Không để trống tên nhóm thực đơn',
            'name.min' => 'Tên thực đơn nhiều hơn 3 ký tự',
            'name.max' => 'Tên thực đơn giới hạn 30 ký tự',
            'name.unique' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống',

            'idCook.required' => 'Vui lòng chọn bếp cho nhóm thực đơn',
        ];

        $req->validate(
            [
                'name' => 'required|min:3|max:30|unique:groupmenu,name',
                'idCook' =>'required'
            ],
            $messeages
        );
    }
    public function validatorRequestUpadate($req){
        $req->validate(['nameGroupMenu' => 'unique:groupmenu,name',],
                        ['nameGroupMenu.unique' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống']);
    }

    public function addGroupMenu($request)
    {
        $groupmenu = new GroupMenu();
        $groupmenu->name = $request->name;
        $groupmenu->id_cook = $request->idCook;
        $groupmenu->save();
        return redirect(route('groupmenu.index'))->withSuccess('Thêm mới nhóm thực đơn thành công');
    }

    public function searchGroupMenu($request)
    {
        $temp = $request->nameSearch;
        $groupmenus = GroupMenu::where('name','LIKE',"%{$temp}%")->get();
        $cooks = CookArea::all();
        $cook_active = array();
        foreach ($cooks as $key => $cook) {
            if($cook->status != '0'){
                $cook_active[] = $cook;
            }
        }
        return view('groupmenu.search',compact('groupmenus','cook_active'));
    }

    public function updateNameGroupMenu($request, $id)
    {
        GroupMenu::where('id',$id)->update(['name' => $request->nameGroupMenu]);
        return redirect(route('groupmenu.index'))->with('info','Cập nhật tên nhóm thực đơn thành công');
    }

    public function getMaterialDetailsByMaterial($arrayIdMaterials)
    {
        $data = array();
        foreach ($arrayIdMaterials as $key => $value) {
            // lấy ra đc mảng, chứa nVL từng món
            $materialDetails = MaterialAction::where('id_groupnvl',$value->id)->get('id_material_detail');
            foreach ($materialDetails as $key => $item) {
                array_push($data,$item->id_material_detail);
            }
        }
        $data = array_unique($data);
        return $data;
    }

    public function addMaterialDetailsChangeCook($arrayMaterialDetails,$cookChange)
    {
        foreach ($arrayMaterialDetails as $key => $item) {
            $warehousecook = new WarehouseCook();
            $warehousecook->cook = $cookChange;
            $warehousecook->id_material_detail = $item->id_material_detail;
            $warehousecook->id_unit = $item->id_unit;
            $warehousecook->qty = 0;
            $warehousecook->status = 0; // = 1 còn NVL ; = 0 báo động cần nhập
            $warehousecook->save();
        }
    }
    public function moveMaterialDetailsChangeCook($arrMaterialDetailsInNewCook,$cookChange,$idOldCook)
    {
        foreach ($arrMaterialDetailsInNewCook as $key => $item) {
            $qtyOldCook = WarehouseCook::where('cook',$idOldCook)->where('id_material_detail',$item->id_material_detail)->value('qty');
            $qtyNewCook = WarehouseCook::where('cook',$cookChange)->where('id_material_detail',$item->id_material_detail)->value('qty');
            WarehouseCook::where('cook',$cookChange)->where('id_material_detail',$item->id_material_detail)
                            ->update(['qty' => $qtyNewCook + $qtyOldCook]);
            WarehouseCook::where('cook',$idOldCook)->where('id_material_detail',$item->id_material_detail)
                            ->update(['qty' => 0]);
        }
    }
    public function updateCookGroupMenu($request, $id)
    {
        $arrayIdMaterials = Material::where('id_groupmenu',$id)->get('id'); // lấy id những món thuộc group vừa thay đổi bếp
        $arrayIdDetailMaterials = $this->getMaterialDetailsByMaterial($arrayIdMaterials); // id nvl tạo nên những món thuộc group đó
        $cookChange = $request->idCook; // bếp mới mà user muốn thay đổi
        $idOldCook = GroupMenu::where('id',$id)->value('id_cook'); // lấy ra bếp đã đảm nhiệm group vừa muốn thay đổi đó
        // lấy ra những nvl trong bếp mới(bếp muốn thay đổi)
        $nvlInNewCook = WarehouseCook::where('cook',$cookChange)->get('id_material_detail');
        // lấy ra những nvl tạo nên group đó mà ko có trong bếp mới
        $arrMaterialDetailsNotInNewCook = WarehouseCook::where('cook',$idOldCook)
                                                ->whereIn('id_material_detail',$arrayIdDetailMaterials)
                                                ->whereNotIn('id_material_detail',$nvlInNewCook)->get();
        // lấy ra những nvl tạo nên group đó đã có trong bếp mới
        $arrMaterialDetailsInNewCook = WarehouseCook::where('cook',$idOldCook)->whereIn('id_material_detail',$arrayIdDetailMaterials)
                                                        ->whereIn('id_material_detail',$nvlInNewCook)->get();
        if($request->move == null){
            $this->addMaterialDetailsChangeCook($arrMaterialDetailsNotInNewCook,$cookChange);
        }else{
            $this->addMaterialDetailsChangeCook($arrMaterialDetailsNotInNewCook,$cookChange);
            $this->moveMaterialDetailsChangeCook($arrMaterialDetailsInNewCook,$cookChange,$idOldCook);
        }
        GroupMenu::where('id',$id)->update(['id_cook' => $request->idCook]);
        return redirect(route('groupmenu.index'))->with('info','Cập nhật bếp cho nhóm thực đơn thành công');
    }
    public function deleteGroupMenu($id)
    {
        GroupMenu::find($id)->delete();
        Dishes::where('id_groupmenu',$id)->delete();
        // lấy ra những món thuộc groupmenu này trong material
        $arrNameDish = Material::where('id_groupmenu',$id)->get('id');
        MaterialAction::whereIn('id_groupnvl',$arrNameDish)->delete();
        Material::where('id_groupmenu',$id)->delete();
        return redirect(route('groupmenu.index'))->withSuccess('Xóa thực đơn thành công');
    }
}
