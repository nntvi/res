<?php
namespace App\Repositories\OrderRepository;

use App\Http\Controllers\Controller;
use App\Area;
use App\Dishes;
use App\GroupMenu;
use App\MaterialAction;
use App\Table;
use Carbon\Carbon;
use App\Order;
use App\OrderDetailTable;
use App\Topping;
use App\WarehouseCook;

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
        $activeTables= Order::whereBetween('created_at',
                                         [$date . ' 00:00:00',
                                          $date . ' 23:59:59'])
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
        $idCook = Dishes::where('id',$idDish)
                            ->with('material.groupMenu.cookArea')
                            ->first();
        return $idCook->material->groupMenu->cookArea->id;
    }

    public function findInWarehouseCook($idCook,$idMaterialDetails)
    {
        $detailWarehouse = WarehouseCook::where('cook',$idCook)
                                        ->whereIn('id_material_detail',$idMaterialDetails)
                                        ->orderBy('id_material_detail')
                                        ->get();
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
        if($a == $b)
            return true;
        else
            return false;
    }
    public function addOrderTableTrue($idDish,$idOrderTable)
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
    }
    public function addOrderTableFalse($idDish,$idOrderTable)
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
                $this->addOrderTableTrue($idDish,$idOrderTable);
            }else{
                $this->addOrderTableFalse($idDish,$idOrderTable);
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
                $this->addOrderTableTrue($idDish,$idOrderTable);
            }else{
                $this->addOrderTableFalse($idDish,$idOrderTable);
            }
        }
        return redirect(route('order.update',['id' => $idOrderTable]));
    }
    // public function calculateMaterial($idDish)
    // {
    //     $idGroupNVL = $this->findIdGroupNVL($idDish);
    //     $idCook = $this->findIdCook($idDish);
    //     $idMaterialDetails = $this->getOnlyIdMaterialAction($idGroupNVL);
    //     $materialInWarehouseCooks = $this->findInWarehouseCook($idCook,$idMaterialDetails);
    //     $materialInActions = $this->getMaterialAction($idGroupNVL);
    //     $count = 0;
    //     $sum = 0;
    //     $data = array();

    //     $countIdMaterialDetails = count($this->getOnlyIdMaterialAction($idGroupNVL));

    //     foreach ($materialInWarehouseCooks as $key => $matCook) {
    //         $data[$key] = $matCook->qty;
    //         foreach ($materialInActions as $matAction) {
    //             if($matCook->id_material_detail == $matAction->id_material_detail){
    //                 if($matCook->qty - $matAction->qty >= 0){
    //                     $data[$key] = $matCook->qty - $matAction->qty;
    //                     $sum++;
    //                 }
    //             }
    //         }
    //     }

    //     if($sum == $countIdMaterialDetails){
    //         $count++;
    //     }
    // }
}
