<?php
namespace App\Repositories\GroupMenuRepository;

use App\Dishes;
use App\EndDay;
use App\CookArea;
use App\Material;
use App\StartDay;
use App\GroupMenu;
use App\HistoryWhCook;
use Carbon\Carbon;
use App\WarehouseCook;
use App\MaterialAction;
use App\Http\Controllers\Controller;
use App\Order;
use App\Repositories\GroupMenuRepository\IGroupMenuRepository;

class GroupMenuRepository extends Controller implements IGroupMenuRepository{
    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_NHOM_THUC_DON"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "TAO_NHOM_THUC_DON"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_NHOM_THUC_DON"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleDelete($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XOA_NHOM_THUC_DON"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getAllGroupMenu()
    {
        $groupmenus = GroupMenu::with('cookArea')->where('status','1')->orderBy('name','asc')->get();
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
        $req->validate(
            [   'name' => 'status_groupmenu|special_character',
                'idCook' =>'required',
            ],
            [   'name.status_groupmenu' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống',
                'name.special_character' => 'Tên nhóm thực đơn không được chứa kí tự đặc biệt',
                'idCook.required' => 'Vui lòng chọn bếp cho nhóm thực đơn'
            ],
        );
    }

    public function validatorRequestUpadate($req){
        $req->validate(['nameGroupMenu' => 'status_groupmenu|special_character'],
                        ['nameGroupMenu.status_groupmenu' => 'Tên thực đơn vừa nhập đã tồn tại trong hệ thống',
                            'nameGroupMenu.special_character' => 'Tên nhóm thực đơn không được chứa kí tự đặc biệt',
                        ]);
    }

    public function addGroupMenu($request)
    {
        $groupmenu = new GroupMenu();
        $groupmenu->name = $request->name;
        $groupmenu->id_cook = $request->idCook;
        $groupmenu->status = '1';
        $groupmenu->save();
        return redirect(route('groupmenu.index'))->withSuccess('Thêm mới nhóm thực đơn thành công');
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

    public function getToday()
    {
        $nowDay = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        return $nowDay;
    }

    public function checkStartDay()
    {
        $nowDay = $this->getToday();
        $value = StartDay::where('date',$nowDay)->value('date');
        return $value;
    }

    public function checkEndDay()
    {
        $nowDay = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $value = EndDay::where('date',$nowDay)->value('id');
        return $value;
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

    public function updateMaterialDetailInOldCookToZero($idOldCook,$idMaterialDetail)
    {
        WarehouseCook::where('cook',$idOldCook)->where('id_material_detail',$idMaterialDetail)->update(['qty' => 0]);
    }

    public function addMaterialDetailsChangeCookMove($arrayMaterialDetails,$cookChange,$idOldCook) // thêm mới nvl vào bếp mới
    {
        foreach ($arrayMaterialDetails as $key => $item) {
            $warehousecook = new WarehouseCook();
            $warehousecook->cook = $cookChange;
            $warehousecook->id_material_detail = $item->id_material_detail;
            $warehousecook->id_unit = $item->id_unit;
            $warehousecook->qty = $item->qty;
            $warehousecook->status = $item->qty > 0 ? '1' : '0'; // = 1 còn NVL ; = 0 báo động cần nhập
            $warehousecook->save();
            $this->updateMaterialDetailInOldCookToZero($idOldCook,$item->id_material_detail);
        }
    }

    public function addMaterialDetailsToHistoryCook($arrayMaterialDetails,$cookChange)
    {
        foreach ($arrayMaterialDetails as $key => $item) {
            $historyCook = new HistoryWhCook();
            $historyCook->id_cook = $cookChange;
            $historyCook->id_material_detail = $item->id_material_detail;
            $historyCook->first_qty = $item->qty;
            $historyCook->last_qty = $item->qty;
            $historyCook->id_unit = $item->id_unit;
            $historyCook->save();
        }
    }

    public function getQtyInOldCook($idOldCook,$idMaterialDetail)
    {
        $qty = WarehouseCook::where('cook',$idOldCook)->where('id_material_detail',$idMaterialDetail)->value('qty');
        return $qty;
    }

    public function getQtyInNewCook($cookChange,$idMaterialDetail)
    {
        $qty = WarehouseCook::where('cook',$cookChange)->where('id_material_detail',$idMaterialDetail)->value('qty');
        return $qty;
    }

    public function getFirstQtyNewCookInWarehouseCook($cookChange,$dateStart,$idMaterialDetail)
    {
        $firstQty = HistoryWhCook::where('id_cook',$cookChange)->whereBetween('created_at',[$dateStart . " 00:00:00", $dateStart . " 23:59:59"])
                                    ->where('id_material_detail',$idMaterialDetail)->value('first_qty');
        return $firstQty;
    }

    public function updateFirstQtyHistoryNewCook($cookChange,$idMaterialDetail,$firstQty,$qtyOldCook,$dateStart)
    {
        HistoryWhCook::whereBetween('created_at',[$dateStart . " 00:00:00", $dateStart . " 23:59:59"])->where('id_cook',$cookChange)
                        ->where('id_material_detail',$idMaterialDetail)->update(['first_qty' => $firstQty + $qtyOldCook]);
    }
    public function updateWarehouseCook($idOldCook,$cookChange,$idMaterialDetail,$qtyNewCook,$qtyOldCook)
    {
        WarehouseCook::where('cook',$cookChange)->where('id_material_detail',$idMaterialDetail)->update(['qty' => $qtyNewCook + $qtyOldCook]);
        WarehouseCook::where('cook',$idOldCook)->where('id_material_detail',$idMaterialDetail)->update(['qty' => 0]);
    }

    public function moveMaterialDetailsChangeCook($arrMaterialDetailsInNewCook,$cookChange,$idOldCook,$dateStart)
    {
        if($dateStart == null){ // chưa khai ca
            foreach ($arrMaterialDetailsInNewCook as $key => $item) {
                $qtyOldCook = $this->getQtyInOldCook($idOldCook,$item->id_material_detail); // get sl của nvl đó trong bếp cũ
                $qtyNewCook = $this->getQtyInNewCook($cookChange,$item->id_material_detail); // get sl của nvl đó trong bếp mới
                $this->updateWarehouseCook($idOldCook,$cookChange,$item->id_material_detail,$qtyNewCook,$qtyOldCook);
            }
        }else{ // đã khai ca
            foreach ($arrMaterialDetailsInNewCook as $key => $item) {
                $qtyOldCook = $this->getQtyInOldCook($idOldCook,$item->id_material_detail);
                $qtyNewCook = $this->getQtyInNewCook($cookChange,$item->id_material_detail);
                $firstQty = $this->getFirstQtyNewCookInWarehouseCook($cookChange,$dateStart,$item->id_material_detail);
                $this->updateFirstQtyHistoryNewCook($cookChange,$item->id_material_detail,$firstQty,$qtyOldCook,$dateStart);
                $this->updateWarehouseCook($idOldCook,$cookChange,$item->id_material_detail,$qtyNewCook,$qtyOldCook);
            }
        }
    }

    public function checkOrder($dateStart)
    {
        $count = Order::selectRaw('count(code) as qty')->whereBetween('created_at',[$dateStart . " 00:00:00",$dateStart . " 23:59:59"])->value('qty');
        return $count;
    }

    public function getMaterialByIdGroupMenu($id)
    {
        $idMaterials = Material::where('id_groupmenu',$id)->get('id');
        return $idMaterials;
    }

    public function updateCookGroupMenu($request, $id)
    {
        $arrayIdMaterials = $this->getMaterialByIdGroupMenu($id); // lấy id những món thuộc group vừa thay đổi bếp
        $arrayIdDetailMaterials = $this->getMaterialDetailsByMaterial($arrayIdMaterials); // id nvl tạo nên những món thuộc group đó
        $cookChange = $request->idCook; // bếp mới mà user muốn thay đổi
        $idOldCook = GroupMenu::where('id',$id)->value('id_cook'); // lấy ra bếp đã đảm nhiệm group vừa muốn thay đổi đó
        $nvlInNewCook = WarehouseCook::where('cook',$cookChange)->get('id_material_detail'); // lấy ra những nvl trong bếp mới(bếp muốn thay đổi)
        // lấy ra những nvl tạo nên group đó mà ko có trong bếp mới
        $arrMaterialDetailsNotInNewCook = WarehouseCook::where('cook',$idOldCook)->whereIn('id_material_detail',$arrayIdDetailMaterials)
                                             ->whereNotIn('id_material_detail',$nvlInNewCook)->get();
        //lấy ra những nvl tạo nên group đó đã có trong bếp mới
        $arrMaterialDetailsInNewCook = WarehouseCook::where('cook',$idOldCook)->whereIn('id_material_detail',$arrayIdDetailMaterials)
                                             ->whereIn('id_material_detail',$nvlInNewCook)->get();
        if($request->move == null){ // ko muốn kết chuyển NVL
            $this->addMaterialDetailsChangeCook($arrMaterialDetailsNotInNewCook,$cookChange);
            GroupMenu::where('id',$id)->update(['id_cook' => $request->idCook]);
            return redirect(route('groupmenu.index'))->with('info','Cập nhật bếp cho nhóm thực đơn thành công');
        }else{ // muốn cộng dồn NVL đã có ở bếp cũ vào bếp mới và thêm mới cái chưa có
            $dateStart = $this->checkStartDay();
            if($dateStart == null){ // chưa khai ca ngày hôm đó
                if($this->checkOrder($this->getToday()) != 0){
                    return redirect(route('groupmenu.index'))->withErrors('Chỉ được chuyển NVL khi chưa có order nào trong ngày');
                }else{
                    $this->addMaterialDetailsChangeCookMove($arrMaterialDetailsNotInNewCook,$cookChange,$idOldCook); // thêm sl của các nvl chưa có ở bếp cũ sang bếp mới
                    $this->moveMaterialDetailsChangeCook($arrMaterialDetailsInNewCook,$cookChange,$idOldCook,$dateStart);
                    GroupMenu::where('id',$id)->update(['id_cook' => $request->idCook]);
                    return redirect(route('groupmenu.index'))->with('info','Cập nhật bếp cho nhóm thực đơn thành công');
                }
            }else{// đã khai ca
                if($this->checkOrder($this->getToday()) != 0){
                    return redirect(route('groupmenu.index'))->withErrors('Chỉ được chuyển NVL khi chưa có order nào trong ngày');
                }else{
                    $this->addMaterialDetailsChangeCookMove($arrMaterialDetailsNotInNewCook,$cookChange,$idOldCook); // thêm sl của các nvl chưa có ở bếp cũ sang bếp mới
                    $this->addMaterialDetailsToHistoryCook($arrMaterialDetailsNotInNewCook,$cookChange);
                    $this->moveMaterialDetailsChangeCook($arrMaterialDetailsInNewCook,$cookChange,$idOldCook,$dateStart);
                    GroupMenu::where('id',$id)->update(['id_cook' => $request->idCook]);
                    HistoryWhCook::whereBetween('created_at',[$dateStart . " 00:00:00", $dateStart . " 23:59:59"])->where('id_cook',$idOldCook)
                                    ->whereIn('id_material_detail',$arrayIdDetailMaterials)->update(['first_qty' => 0,'last_qty' => 0]);
                    return redirect(route('groupmenu.index'))->with('info','Cập nhật bếp cho nhóm thực đơn thành công');
                }
            }
        }
    }

    public function deleteGroupMenu($id)
    {
        // xóa món trước
        Dishes::where('id_groupmenu',$id)->update(['stt' => '0']);
        // lấy ra những món thuộc groupmenu này trong material
        $arrNameDish = Material::where('id_groupmenu',$id)->get('id');
        // xóa công thức tất cả các món thuộc nhóm thực đơn đó
        MaterialAction::whereIn('id_groupnvl',$arrNameDish)->delete();
        // xóa tên món thuộc nhóm ở material
        Material::where('id_groupmenu',$id)->update(['status' => '0']);
        // cuối cùng xóa nhóm
        GroupMenu::where('id',$id)->update(['status' => '0']);
        return redirect(route('groupmenu.index'))->withSuccess('Xóa nhóm thực đơn thành công');
    }
}
