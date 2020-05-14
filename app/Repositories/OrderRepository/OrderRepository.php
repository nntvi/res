<?php
namespace App\Repositories\OrderRepository;

use App\Area;
use App\Order;
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
        $idOrders = Order::whereBetween('created_at',[$date . ' 00:00:00', $date . ' 23:59:59'])
                        ->with('table.getArea')->get();
        return $idOrders;
    }

    public function getDishes()
    {
        $groupmenus = GroupMenu::with('dishes')->get();
        return $groupmenus;
    }

    public function getIdTableActive($date)
    {
        $activeTables= Order::whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])
                            ->where('status', '1')->get('id_table');
        return $activeTables;
    }

    public function getTableIsNotActive($activeTables)
    {
        $inActiveTables = Table::whereNotIn('id', $activeTables)->get();
        return $inActiveTables;
    }

    public function getOnlyIdMaterialAction($idGroupNVL)
    {
        $idMaterialDetails = MaterialAction::where('id_groupnvl',$idGroupNVL)
                                            ->orderBy('id_material_detail')
                                            ->get('id_material_detail');
        return $idMaterialDetails;
    }

    public function getMaterialAction($idGroupNVL)
    {
        $materialDetails = MaterialAction::where('id_groupnvl',$idGroupNVL)->get();
        return $materialDetails;
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
        $detailWarehouse = WarehouseCook::where('cook',$idCook)
                                        ->whereIn('id_material_detail',$idMaterialDetails)
                                        ->orderBy('id_material_detail')->get();
        return $detailWarehouse;
    }

    public function showTableInDay()
    {
        $areas = $this->getArea();
        $date = $this->getDateNow();
        $idOrders = $this->getOrders($date);
        return view('order.index',compact('areas','idOrders'));
    }

    public function orderTable()
    {
        $date = $this->getDateNow();
        $activeTables = $this->getIdTableActive($date);
        $inActiveTables = $this->getTableIsNotActive($activeTables);
        $groupmenus = $this->getDishes();
        return view('order.orderTable',compact('groupmenus','inActiveTables'));
    }

    public function saveOrder($request)
    {
        $orderTable = new Order();
        $orderTable->id_table = $request->idTable;
        $orderTable->status = '1'; // đang order, chưa thanh toán
        $orderTable->created_by = auth()->user()->name;
        $orderTable->time_created = Carbon::now('Asia/Ho_Chi_Minh')->format('H:m:s');
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
    public function addOrderTableTrue($idDish,$idOrderTable,$idCook)
    {
        $price = Dishes::where('id',$idDish)->first();
            $data = [
                'id_bill' => $idOrderTable,
                'qty' => 1,
                'id_dish' => $idDish,
                'price' => $price->sale_price,
                'status' => '0'
            ];
        OrderDetailTable::create($data);
        $this->notifyNewDishForCook($idCook,$idDish);
    }
    public function addOrderTableFalse($idDish,$idOrderTable,$idCook)
    {
        $price = Dishes::where('id',$idDish)->first();
            $data = [
                'id_bill' => $idOrderTable,
                'qty' => 1,
                'id_dish' => $idDish,
                'price' => $price->sale_price,
                'status' => '-1'
            ];
        OrderDetailTable::create($data);
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
        $data['idCook'] = $idCook;
        $data['nameDish'] = Dishes::where('id',$idDish)->value('name');
        $pusher->trigger('NotifyCook', 'notify-cook', $data);
    }
    public function addDishesOrder($idDishes,$idOrderTable)
    {
        foreach ($idDishes as $key => $idDish) {
            $idGroupNVL = $this->findIdGroupNVL($idDish);
            $idCook = $this->findIdCook($idDish);
            $idMaterialDetails = $this->getOnlyIdMaterialAction($idGroupNVL);
            $materialInWarehouseCooks = $this->findInWarehouseCook($idCook,$idMaterialDetails);
            $materialInActions = $this->getMaterialAction($idGroupNVL);
            if($this->compare($materialInWarehouseCooks,$materialInActions)){
                $this->addOrderTableTrue($idDish,$idOrderTable,$idCook);
            }else{
                $this->addOrderTableFalse($idDish,$idOrderTable,$idCook);
            }
        }
    }

    public function orderTablePost($request)
    {
        $idOrderTable = $this->saveOrder($request);
        $idDishes = $request->idDish;
        $this->addDishesOrder($idDishes,$idOrderTable);
        return redirect(route('order.update',['id' => $idOrderTable]));
    }

    public function addMoreDish($request,$idOrderTable)
    {
        $idDishes = $request->idDish;
        foreach ($idDishes as $idDish) {
            $idGroupNVL = $this->findIdGroupNVL($idDish);
            $idCook = $this->findIdCook($idDish);
            $idMaterialDetails = $this->getOnlyIdMaterialAction($idGroupNVL);
            $materialInWarehouseCooks = $this->findInWarehouseCook($idCook,$idMaterialDetails);
            $materialInActions = $this->getMaterialAction($idGroupNVL);
            if($this->compare($materialInWarehouseCooks,$materialInActions)){
                $this->addOrderTableTrue($idDish,$idOrderTable,$idCook);
            }else{
                $this->addOrderTableFalse($idDish,$idOrderTable,$idCook);
            }
        }
        return redirect(route('order.update',['id' => $idOrderTable]));
    }
}
