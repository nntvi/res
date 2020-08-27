<?php
namespace App\Repositories\CookScreenRepository;

use App\Dishes;
use App\CookArea;
use App\Material;
use App\WareHouse;
use Carbon\Carbon;
use Pusher\Pusher;
use App\WarehouseCook;
use App\MaterialAction;
use App\MaterialDetail;
use App\OrderDetailTable;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderTable;
use Illuminate\Http\Request;

class CookScreenRepository extends Controller implements ICookScreenRepository{

    public function getDishByIdDishOrder($idDishOrder)
    {
        $dish = OrderDetailTable::where('id',$idDishOrder)->with('dish','order.tableOrdered.table')->first();
        return $dish;
    }

    public function getIdDishByIdDishOrder($idDishOrder)
    {
        $idDish = OrderDetailTable::where('id',$idDishOrder)->value('id_dish');
        return $idDish;
    }

    public function getQtyDishOrderByIdDishOrder($idDishOrder)
    {
        $qty = OrderDetailTable::where('id',$idDishOrder)->value('qty');
        return $qty;
    }

    public function getIdCookByGroupNVL($idGroupNVL)
    {
        $idCook = Material::where('id',$idGroupNVL)->with('groupMenu.cookArea')->first();
        return $idCook->groupMenu->cookArea->id;
    }

    public function getAllCookArea()
    {
        $cooks = CookArea::where('status','1')->get();
        return $cooks;
    }
    public function getDateNow()
    {
        $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        return $date;
    }

    public function checkAnythingIsDoing($idCook)
    {
        $today = $this->getDateNow();
        $qty = OrderDetailTable::selectRaw('count(id) as qty')->whereBetween('updated_at',[$today . " 00:00:00",$today . " 23:59:59"])
                ->whereHas('dish.groupMenu.cookArea', function ($q) use ($idCook)
                {
                    $q->where('id',$idCook);
                })->where('status','1')->value('qty');
        return $qty;
    }

    public function checkDishToDoFirst($idCook,$id)
    {
        $today = $this->getDateNow();
        $timeCreateOfDish = OrderDetailTable::where('id',$id)->value('created_at');
        $count = OrderDetailTable::selectRaw('count(id) as qty')->whereBetween('created_at',[$today . " 00:00:00",$today . " 23:59:59"])
                    ->whereHas('dish.groupMenu.cookArea', function ($q) use ($idCook)
                    {
                        $q->where('id',$idCook);
                    })->where('status','0')->where('created_at','<',$timeCreateOfDish)->value('qty');
        return $count;
    }

    public function getDishesByDate($date,$id)
    {
        $dishes = OrderDetailTable::whereBetween('created_at',[$date . ' 00:00:00', $date . ' 23:59:59'])
                                    ->orderBy('created_at','desc')->whereIn('status',['0','1'])
                                    ->with('dish.groupMenu.cookArea','dish.material.materialAction.materialDetail',
                                            'dish.material.materialAction.unit','order.tableOrdered.table')
                                    ->whereHas('dish.groupMenu.cookArea', function ($query) use ($id)
                                    {
                                        $query->where('id',$id);
                                    })->get();
        return $dishes;
    }

    public function getMaterialInWarehouseCook($idCook)
    {
        $materials = WarehouseCook::where('cook',$idCook)->with('detailMaterial','unit')->get();
        return $materials;
    }

    public function checkDishDestroyOrNot($id)
    {
        $status = OrderDetailTable::where('id',$id)->value('status');
        return $status;
    }

    public function findCookAreaById($id)
    {
        $cook = CookArea::where('id',$id)->first();
        return $cook;
    }

    public function validateToCook($request)
    {
        $request->validate(
            ['qtyOrder' => 'check_to_cook'],
            ['qtyOrder.check_to_cook' => 'Có món đang thực hiện, không thể sang món mới']
        );
    }

    public function checkRoleDetail($results)
    {
        $temp = 0;
        for ($i=0; $i < count($results); $i++) {
            if($results[$i] == "XEM_FULL"){
                return 0;
                break;
            }else if($results[$i] == "XEM_BEP1"){
                return 1;
                break;
            }
            else if($results[$i] == "XEM_BEP2"){
                return 2;
                break;
            }
            else if($results[$i] == "XEM_BEP3"){
                return 3;
                break;
            }
            else{
                $temp++;
            }
        }
        if($temp != 0){
            return 4;
        }
    }

    public function checkWarehouseCook($a,$b,$qtyOrder,$materialInWarehouseCooks,$materialInActions)
    {
        if($a != $b) { // ko đủ NVL thực hiện hết số sp order
            if($qtyOrder == 1){ // chỉ order 1 món hàng và check thấy ko đủ
                return 0;
            }else if($qtyOrder > 1){
                $qtyOrder -=1;
                return $this->compareWarehouseCook($materialInWarehouseCooks,$materialInActions,$qtyOrder);
            }
        }else{
            return $qtyOrder;
        }
    }

    public function compareWarehouseCook($materialInWarehouseCooks,$materialInActions,$qtyOrder)
    {
        $a = 0;$b = 0;
        foreach ($materialInWarehouseCooks as $matCook) {
            $a++;
            foreach ($materialInActions as $matAction) {
                if($matCook->id_material_detail == $matAction->id_material_detail){
                    if(($matCook->qty - ($matAction->qty) * $qtyOrder) >=0){ // vd đặt 10 lon coca , kho chỉ còn 7 lon => 3 lon kia ??
                        $b++;
                    }
                }
            }
        }
        return $this->checkWarehouseCook($a,$b,$qtyOrder,$materialInWarehouseCooks,$materialInActions);
    }

    public function checkWarehouse($a,$b,$qtyNotEnough,$materialInWarehouse,$materialInActions)
    {
        if($a != $b) { // ko đủ NVL thực hiện hết số sp order
            if($qtyNotEnough == 1){ // chỉ order 1 món hàng và check thấy ko đủ
                return 0;
            }else if($qtyNotEnough > 1){
                $qtyNotEnough -=1;
                return $this->compareWarehouse($materialInWarehouse,$materialInActions,$qtyNotEnough);
            }
        }else{
            return $qtyNotEnough;
        }
    }

    public function compareWarehouse($materialInWarehouse,$materialInActions,$qtyNotEnough)
    {
        $a = 0; $b = 0;
        foreach ($materialInWarehouse as $matWarehouse) {
            $a++;
            foreach ($materialInActions as $matAction) {
                if($matWarehouse->id_material_detail == $matAction->id_material_detail){
                    if($matWarehouse->qty - (($matAction->qty) * $qtyNotEnough) >=0){
                        $b++; // nếu NVL trong kho trừ cho công thức >0 => vẫn đủ đề làm
                    }
                }
            }
        }
        return $this->checkWarehouse($a,$b,$qtyNotEnough,$materialInWarehouse,$materialInActions);
    }

    public function getDetailCookScreen($id)
    {
        $cook = $this->findCookAreaById($id);
        $date = $this->getDateNow();
        $data = $this->getDishesByDate($date,$id);
        $materials = $this->getMaterialInWarehouseCook($id);
        return view('cookscreen.detail',compact('data','cook','materials'));
    }

    public function getMaterialByIdCook($idCook)
    {
        $materials = $this->getMaterialInWarehouseCook($idCook);
        $cook = $this->findCookAreaById($idCook);
        return view('cookscreen.material',compact('materials','cook'));
    }

    public function updateStatusWarehouseCook($idMaterial,$idCook)
    {
        WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterial)->update(['status' => '0']);
        $data['idCook'] = (integer) $idCook;
        $data['material'] = MaterialDetail::where('id',$idMaterial)->value('name');
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            'cc6422348edc9fbaff00',
            '54d59c765665f5bc6194',
            '994181',
            $options
        );
        $pusher->trigger('NotifyOutOfStock', 'need-import-cook', $data);
    }

    public function findIdGroupNVL($idDish)
    {
        $idGroupNVL = Dishes::where('id',$idDish)->value('id_groupnvl');
        return $idGroupNVL;
    }
    public function getMaterialAction($idGroupNVL)
    {
        $materialDetails = MaterialAction::where('id_groupnvl',$idGroupNVL)->get();
        return $materialDetails;
    }
    public function getOnlyIdMaterialAction($idGroupNVL)
    {
        $idMaterialDetails = MaterialAction::where('id_groupnvl',$idGroupNVL)->orderBy('id_material_detail')->get('id_material_detail');
        return $idMaterialDetails;
    }

    public function findInWarehouseCook($idCook,$idMaterialDetails)
    {
        $detailWarehouse = WarehouseCook::where('cook',$idCook)->whereIn('id_material_detail',$idMaterialDetails)->orderBy('id_material_detail')->get();
        return $detailWarehouse;
    }

    public function findInWarehouse($idMaterialDetails)
    {
        $detailWarehouse = WareHouse::whereIn('id_material_detail',$idMaterialDetails)->orderBy('id_material_detail')->get();
        return $detailWarehouse;
    }

    public function getTableByIdOrder($idOrder)
    {
        $tables = OrderTable::where('id_order',$idOrder)->with('table')->get();
        $stringTable = "";
        foreach ($tables as $key => $table) {
            if(count($tables) > 1 ){
                $stringTable = $stringTable . $table->table->name . " ";
            }
            else{
                $stringTable = $stringTable . $table->table->name;
            }
        }
        return $stringTable;
    }

    public function updateStatusDish($idDishOrder,$idCook,$dishOrder,$qty,$status)
    {
        $stringTable = $this->getTableByIdOrder($dishOrder->id_bill);
        if($status == '1'){ // đang làm
            OrderDetailTable::where('id',$idDishOrder)->update(['qty' => $qty,'status' => $status]);
        }else if($status == '-1'){ // bếp hết NVL
            OrderDetailTable::where('id',$idDishOrder)->update(['qty' => $qty,'status' => $status]);
            $this->notifyDish($dishOrder->id_dish,$qty,$stringTable,$status,$idCook);
            return redirect(route('cook_screen.detail',['id' => $idCook]));
        }else if($status == '-3'){ // kho hết NVL
            OrderDetailTable::where('id',$idDishOrder)->update(['qty' => $qty,'status' => $status]);
            $this->notifyDish($dishOrder->id_dish,$qty,$stringTable,$status,$idCook);
            return redirect(route('cook_screen.detail',['id' => $idCook]))->withErrors('Kho không đủ NVL thực hiện');
        }
    }

    public function notifyDish($idDish,$qty,$nameTable,$status,$idCook)
    {
        $dish = Dishes::where('id',$idDish)->with('unit')->first();
        $data['imgDish'] = $dish->image;
        $data['nameDish'] = $dish->name;
        $data['nameTable'] = $nameTable;
        $data['qty'] = $qty;
        $data['unit'] = $dish->unit->name;
        $data['stt'] = $status;
        $data['idCook'] = $idCook;
            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
            );
            $pusher = new Pusher(
                'cc6422348edc9fbaff00',
                '54d59c765665f5bc6194',
                '994181',
                $options
            );
        $pusher->trigger('FinishDish', 'finish-dish', $data);
    }

    public function createDishEmptyCook($dishOrder,$qtyEmptyCook,$idCook)
    {
        $orderDetailTable = new OrderDetailTable();
        $orderDetailTable->id_bill = $dishOrder->id_bill;
        $orderDetailTable->id_dish = $dishOrder->id_dish;
        $orderDetailTable->price = $dishOrder->dish->sale_price;
        $orderDetailTable->qty = $qtyEmptyCook;
        $orderDetailTable->status = '-1';
        $orderDetailTable->save();
        $this->notifyDish($orderDetailTable->id_dish,$qtyEmptyCook,$this->getTableByIdOrder($dishOrder->id_bill),'-1',$idCook);

    }

    public function createDishEmptyWh($dishOrder,$qtyEmptyWh,$idCook)
    {
        $orderDetailTable = new OrderDetailTable();
        $orderDetailTable->id_bill = $dishOrder->id_bill;
        $orderDetailTable->id_dish = $dishOrder->id_dish;
        $orderDetailTable->price = $dishOrder->dish->sale_price;
        $orderDetailTable->qty = $qtyEmptyWh;
        $orderDetailTable->status = '-3';
        $orderDetailTable->save();
        $this->notifyDish($orderDetailTable->id_dish,$qtyEmptyWh,$this->getTableByIdOrder($dishOrder->id_bill),'-3',$idCook);
    }

    public function getPrevQtyWarehouseCook($idCook,$idMaterialDetail)
    {
        $prevQty = WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetail)->value('qty');
        return $prevQty;
    }

    public function updateFinishDish($idDishOrder,$idCook,$idMaterialDetails,$qtyMethods,$qtyReals,$dish)
    {
        OrderDetailTable::where('id',$idDishOrder)->update(['status' => '2','cooked_by' => auth()->user()->name]);
        for ($i=0; $i < count($idMaterialDetails); $i++) {
            $temp = $this->getPrevQtyWarehouseCook($idCook,$idMaterialDetails[$i]);
            WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetails[$i])->update(['qty' => $temp - ($qtyMethods[$i] * $qtyReals[$i])]);
        }
        $this->notifyDish($dish->dish->id,$dish->qty,$this->getTableByIdOrder($dish->id_bill),'2',$idCook);
        return redirect(route('cook_screen.detail',['id' => $idCook]))->withSuccess('Đã thực hiện xong món: ' . $dish->dish->name . ' ' . $this->getTableByIdOrder($dish->id_bill));
    }

}
