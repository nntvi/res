<?php
namespace App\Repositories\OrderRepository;

use App\Area;
use App\Order;
use App\Shift;
use App\Table;
use App\Dishes;
use App\Topping;
use App\GroupMenu;
use Carbon\Carbon;
use Pusher\Pusher;
use App\WarehouseCook;
use App\MaterialAction;
use App\OrderDetailTable;
use App\Http\Controllers\Controller;

class OrderRepository extends Controller implements IOrderRepository{

    public function validatorOrder($request)
    {
       $request->validate(['idDish' => 'required'],['idDish.required' => 'Vui lòng chọn ít nhất 1 món ăn']);
    }
    public function getArea()
    {
        $areas = Area::with('containTable')->get();
        return $areas;
    }
    public function getDateNow()
    {
        $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        return $date;
    }

    public function getOrders($date)
    {
        $idOrders = Order::whereBetween('created_at',[$date . ' 00:00:00', $date . ' 23:59:59'])->with('table.getArea')->get();
        return $idOrders;
    }

    public function getDishes()
    {
        $groupmenus = GroupMenu::where('status','1')->where('id_cook','!=','0')->with('dishes')->get();
        return $groupmenus;
    }

    public function getIdTableActive($date)
    {
        $activeTables= Order::whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])->where('status', '1')->get();
        return $activeTables;
    }

    public function getTableIsNotActive($activeTables)
    {
        $inActiveTables = Table::whereNotIn('id', $activeTables)->get();
        return $inActiveTables;
    }

    public function getOnlyIdMaterialAction($idGroupNVL)
    {
        $idMaterialDetails = MaterialAction::where('id_groupnvl',$idGroupNVL)->orderBy('id_material_detail')->get('id_material_detail');
        return $idMaterialDetails;
    }

    public function getMaterialAction($idGroupNVL)
    {
        $materialDetails = MaterialAction::where('id_groupnvl',$idGroupNVL)->get();
        return $materialDetails;
    }

    public function countDishCookingorFinish($idOrderTable)
    {
        $qty = OrderDetailTable::selectRaw('count(id) as qty')->where('id_bill',$idOrderTable)->whereIn('status',['1','2'])->value('qty');
        return $qty;
    }
    public function findIdGroupNVL($idDish)
    {
        $idGroupNVL = Dishes::where('id',$idDish)->first('id_groupnvl');
        return $idGroupNVL->id_groupnvl;
    }

    public function findIdCook($idDish)
    {
        $idCook = Dishes::where('id',$idDish)->with('material.groupMenu.cookArea')->first();
        return $idCook->material->groupMenu->cookArea->id;
    }

    public function findInWarehouseCook($idCook,$idMaterialDetails)
    {
        $detailWarehouse = WarehouseCook::where('cook',$idCook)->whereIn('id_material_detail',$idMaterialDetails)->orderBy('id_material_detail')->get();
        return $detailWarehouse;
    }

    public function showTableInDay()
    {
        $tables = Table::where('status','1')->get();
        $activeTables = $this->getIdTableActive($this->getDateNow());
        $groupmenus = $this->getDishes();
        return view('order.index',compact('tables','activeTables','groupmenus'));
    }

    public function generate_string($input, $strength) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }
    public function createCodeBill()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = $this->generate_string($permitted_chars,7);
        return $code;
    }
    public function orderTable()
    {
        $date = $this->getDateNow();
        $activeTables = $this->getIdTableActive($date);
        $inActiveTables = $this->getTableIsNotActive($activeTables);
        $groupmenus = $this->getDishes();
        return view('order.orderTable',compact('groupmenus','inActiveTables'));
    }

    public function checkShift($timeUpdate)
    {
        $idShift = Shift::where([
            ['hour_start', '<=', $timeUpdate],
            ['hour_end', '>=', $timeUpdate],
        ])->value('id');
        return $idShift;
    }

    public function saveOrder($request)
    {
        $orderTable = new Order();
        $orderTable->code = $this->createCodeBill();
        $orderTable->id_table = $request->idTableOrder;
        $orderTable->status = '1'; // đang order, chưa thanh toán
        $orderTable->created_by = auth()->user()->name;
        $orderTable->time_created = Carbon::now('Asia/Ho_Chi_Minh')->format('H:m:s');
        $orderTable->id_shift = $this->checkShift(Carbon::now('Asia/Ho_Chi_Minh')->format('H:m:s'));
        $orderTable->save();
        return $orderTable->id;
    }

    public function compare($materialInWarehouseCooks,$materialInActions)
    {
        $a = 0;
        $b = 0;
        foreach ($materialInWarehouseCooks as $key => $matCook) {
            $a++;
            foreach ($materialInActions as $key => $matAction) {
                if($matCook->id_material_detail == $matAction->id_material_detail){
                    if($matCook->qty - $matAction->qty >=0){
                        $b++;
                    }
                }
            }
        }
        return $a == $b ? true : false ;
    }
    public function getSalePriceOfDish($idDish)
    {
        $price = Dishes::where('id',$idDish)->value('sale_price');
        return $price;
    }
    public function addOrderTableTrue($idDish,$idOrderTable,$idCook,$key,$request)
    {
        $price = $this->getSalePriceOfDish($idDish);
        $orderDetail = new OrderDetailTable();
        $orderDetail->id_bill = $idOrderTable;
        $orderDetail->id_dish = $idDish;
        $orderDetail->qty = $request->qty[$key];
        $orderDetail->price = $price;
        $orderDetail->note = $request->note[$key];
        $orderDetail->status = '0'; // chưa làm
        $orderDetail->save();
        $this->notifyNewDishForCook($idCook,$idDish);
    }
    public function addOrderTableFalse($idDish,$idOrderTable,$idCook,$key,$request)
    {
        $price = $this->getSalePriceOfDish($idDish);
        $orderDetail = new OrderDetailTable();
        $orderDetail->id_bill = $idOrderTable;
        $orderDetail->id_dish = $idDish;
        $orderDetail->qty = $request->qty[$key];
        $orderDetail->price = $price;
        $orderDetail->note = $request->note[$key];
        $orderDetail->status = '-1'; // hết nvl phục vụ
        $orderDetail->save();
        $this->notifyNewDishForCook($idCook,$idDish);
    }

    public function notifyNewDishForCook($idCook,$idDish)
    {
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
        $data['type'] = '1';
        $data['idCook'] = $idCook;
        $data['nameDish'] = Dishes::where('id',$idDish)->value('name');
        $pusher->trigger('NotifyCook', 'notify-cook', $data);
    }

    public function notifyDistroyDish($idDishOrder)
    {
        $dish = OrderDetailTable::where('id',$idDishOrder)->with('dish.groupMenu.cookArea')->first();
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
        $data['type'] = '0';
        $data['idCook'] = $dish->dish->groupMenu->cookArea->id;
        $data['nameDish'] = $dish->dish->name;
        $pusher->trigger('NotifyCook', 'notify-cook', $data);
    }

    public function destroyDish($idDishOrder)
    {
        OrderDetailTable::where('id',$idDishOrder)->update(['status' => '-2']);
        $this->notifyDistroyDish($idDishOrder);
    }

    public function loopDishOrdertoDestroy($arrDishOrder)
    {
        foreach ($arrDishOrder as $key => $dish) {
            $this->destroyDish($dish->id);
        }
    }
    public function addDishesOrder($request,$idOrderTable)
    {
        $idDishes = $request->idDish;
        foreach ($idDishes as $key => $idDish) {
            $idGroupNVL = $this->findIdGroupNVL($idDish);
            $idCook = $this->findIdCook($idDish);
            $idMaterialDetails = $this->getOnlyIdMaterialAction($idGroupNVL);
            $materialInWarehouseCooks = $this->findInWarehouseCook($idCook,$idMaterialDetails);
            $materialInActions = $this->getMaterialAction($idGroupNVL);
            if($this->compare($materialInWarehouseCooks,$materialInActions)){
                $this->addOrderTableTrue($idDish,$idOrderTable,$idCook,$key,$request);
            }else{
                $this->addOrderTableFalse($idDish,$idOrderTable,$idCook,$key,$request);
            }
        }
    }

    public function orderTablePost($request)
    {
        $idOrderTable = $this->saveOrder($request);
        $this->addDishesOrder($request,$idOrderTable);
        return redirect(route('order.index'))->withSuccess('Order thành công');
    }

    public function addMoreDish($request,$idBill)
    {
        $idDishes = $request->idDish;
        foreach ($idDishes as $key => $idDish) {
            $idGroupNVL = $this->findIdGroupNVL($idDish);
            $idCook = $this->findIdCook($idDish);
            $idMaterialDetails = $this->getOnlyIdMaterialAction($idGroupNVL);
            $materialInWarehouseCooks = $this->findInWarehouseCook($idCook,$idMaterialDetails);
            $materialInActions = $this->getMaterialAction($idGroupNVL);
            if($this->compare($materialInWarehouseCooks,$materialInActions)){
                $this->addOrderTableTrue($idDish,$idBill,$idCook,$key,$request);
            }else{
                $this->addOrderTableFalse($idDish,$idBill,$idCook,$key,$request);
            }
        }
    }

}
