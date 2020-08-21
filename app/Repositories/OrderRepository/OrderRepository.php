<?php
namespace App\Repositories\OrderRepository;

use App\Area;
use App\Order;
use App\Shift;
use App\Table;
use App\Dishes;
use App\Topping;
use App\GroupMenu;
use App\WareHouse;
use Carbon\Carbon;
use Pusher\Pusher;
use App\OrderTable;
use App\WarehouseCook;
use App\MaterialAction;
use App\OrderDetailTable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Controller;

class OrderRepository extends Controller implements IOrderRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_GOI_MON"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleIndexBill($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_HOA_DON"){
                $temp++;
            }
        }
        return $temp;
    }

    public function validatorOrder($request)
    {
       $request->validate(['idDish' => 'required'],['idDish.required' => 'Vui lòng chọn ít nhất 1 món ăn']);
    }
    public function getArea()
    {
        $areas = Area::where('status','1')->with(['containTable' => function ($query)
                        {
                            $query->where('status','1');
                        }])->orderBy('name', 'desc')->get();
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
        $groupmenus = GroupMenu::where('status','1')->where('id_cook','!=','0')->with(['dishes' => function ($query)
                                {
                                    $query->orderBy('name','asc');
                                }])->get();
        return $groupmenus;
    }

    public function getIdTableActive($date)
    {
        $activeTables = OrderTable::whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])->where('status', '1')->get();
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
        $detailWarehouseCook = WarehouseCook::where('cook',$idCook)->whereIn('id_material_detail',$idMaterialDetails)
                                ->with('detailMaterial')->orderBy('id_material_detail')->get();
        return $detailWarehouseCook;
    }

    public function findInWarehouse($idMaterialDetails)
    {
        $detailWarehouse = WareHouse::whereIn('id_material_detail',$idMaterialDetails)->orderBy('id_material_detail')->get();
        return $detailWarehouse;
    }
    public function showTableInDay()
    {
        $areas = $this->getArea();
        $tables = Table::where('status','1')->get();
        $activeTables = $this->getIdTableActive($this->getDateNow());
        $groupmenus = $this->getDishes();
        return view('order.index',compact('tables','activeTables','groupmenus','areas'));
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
        return $idShift == null ? null : $idShift;
    }

    public function saveTable($idOrderTable,$idTable)
    {
        $tableOrdered = new OrderTable();
        $tableOrdered->id_order = $idOrderTable;
        $tableOrdered->id_table = $idTable;
        $tableOrdered->status = '1';
        $tableOrdered->save();
    }

    public function saveOrder($request)
    {
        $orderTable = new Order();
        $orderTable->code = $this->createCodeBill();
        $orderTable->status = '1'; // đang order, chưa thanh toán
        $orderTable->created_by = auth()->user()->name;
        $orderTable->time_created = Carbon::now('Asia/Ho_Chi_Minh')->format('H:m:s');
        $orderTable->id_shift = $this->checkShift(Carbon::now('Asia/Ho_Chi_Minh')->format('H:m:s'));
        $orderTable->save();
        return $orderTable->id;
    }

    public function getSalePriceOfDish($idDish)
    {
        $price = Dishes::where('id',$idDish)->value('sale_price');
        return $price;
    }

    public function getCapitalPriceOfDish($idDish)
    {
        $capital = Dishes::where('id',$idDish)->value('capital_price');
        return $capital;
    }
    public function addOrderTableTrue($idDish,$idOrderTable,$idCook,$key,$request,$qty)
    {
        $orderDetail = new OrderDetailTable();
        $orderDetail->id_bill = $idOrderTable;
        $orderDetail->id_dish = $idDish;
        $orderDetail->qty = $qty;
        $orderDetail->price = $this->getSalePriceOfDish($idDish);
        $orderDetail->capital = $this->getCapitalPriceOfDish($idDish);
        $orderDetail->note = $request->note[$key];
        $orderDetail->status = '0'; // chưa làm
        $orderDetail->save();
        $this->notifyNewDishForCook($idCook,$idDish);
    }
    public function addOrderTableFalse($idDish,$idOrderTable,$idCook,$key,$request,$qty)
    {
        $orderDetail = new OrderDetailTable();
        $orderDetail->id_bill = $idOrderTable;
        $orderDetail->id_dish = $idDish;
        $orderDetail->qty = $qty;
        $orderDetail->price = $this->getSalePriceOfDish($idDish);
        $orderDetail->note = $request->note[$key];
        $orderDetail->status = '-1'; // hết nvl trong bếp để làm món
        $orderDetail->save();
        $this->notifyNewDishForCook($idCook,$idDish);
    }

    public function addOrderTableFalseWarehouse($idDish,$idOrderTable,$idCook,$key,$request,$qty)
    {
        $orderDetail = new OrderDetailTable();
        $orderDetail->id_bill = $idOrderTable;
        $orderDetail->id_dish = $idDish;
        $orderDetail->qty = $qty;
        $orderDetail->price = $this->getSalePriceOfDish($idDish);
        $orderDetail->note = $request->note[$key];
        $orderDetail->status = '-3'; // hết nvl trong kho để làm
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
            $idGroupNVL = $this->findIdGroupNVL($idDish); // tìm nhóm thực đơn của món đó
            $idCook = $this->findIdCook($idDish); // id cook nào đảm nhiệm
            $idMaterialDetails = $this->getOnlyIdMaterialAction($idGroupNVL); // những NVL tạo nên món đó
            $materialInWarehouseCooks = $this->findInWarehouseCook($idCook,$idMaterialDetails);
            $materialInWarehouse = $this->findInWarehouse($idMaterialDetails);
            $materialInActions = $this->getMaterialAction($idGroupNVL);
            $qtyOrder = $request->qty[$key];
            $this->addOrderTableTrue($idDish,$idOrderTable,$idCook,$key,$request,$qtyOrder);
        }
    }

    public function orderTablePost($request)
    {
        $idOrderTable = $this->saveOrder($request);
        $this->saveTable($idOrderTable,$request->idTableOrder);
        $this->addDishesOrder($request,$idOrderTable);
        $status = Order::where('id',$idOrderTable)->value('status');
        $data = [
            'idOrderTable' => $idOrderTable,
            'status' => $status
        ];
        return $data;
    }

    public function addMoreDish($request,$idBill)
    {
        $idDishes = $request->idDish;
        foreach ($idDishes as $key => $idDish) {
            $idGroupNVL = $this->findIdGroupNVL($idDish);
            $idCook = $this->findIdCook($idDish);
            $idMaterialDetails = $this->getOnlyIdMaterialAction($idGroupNVL);
            $materialInWarehouseCooks = $this->findInWarehouseCook($idCook,$idMaterialDetails);
            $materialInWarehouse = $this->findInWarehouse($idMaterialDetails);
            $materialInActions = $this->getMaterialAction($idGroupNVL);
            $qtyOrder = $request->qty[$key];
            $this->addOrderTableTrue($idDish,$idBill,$idCook,$key,$request,$qtyOrder);
        }
    }

}
