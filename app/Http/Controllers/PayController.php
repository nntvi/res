<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetailTable;
use App\MaterialAction;
use App\Dishes;
use App\Inventory;
use App\Repositories\PayRepository\IPayRepository;
use App\WareHouseDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
class PayController extends Controller

{
    private $payRepository;

    public function __construct(IPayRepository $payRepository)
    {
       $this->payRepository = $payRepository;
    }

    public function index($id)
    {
        return $this->payRepository->showBill($id);
    }

    public function print($id)
    {
        return $this->payRepository->printBill($id);
    }
    public function update(Request $request,$id)
    {
        return $this->payRepository->updateStatusOrder($request,$id);
    }

    // public function substract($idDishes)
    // {
    //     foreach ($idDishes as $key => $idDish) {
    //         $this->check($idDish->id_dish);
    //     }
    // }

    // public function check($idDish)
    // {
    //     $groupnvl = Dishes::where('id',$idDish)->first();

    //     $materialActionById = MaterialAction::where('id_groupnvl',$groupnvl->id_groupnvl)->get('id_material_detail');
    //     $materialAction = MaterialAction::where('id_groupnvl',$groupnvl->id_groupnvl)->get();
    //     $detailWarehouse = WareHouseDetail::whereIn('id_material_detail',$materialActionById)->get();

    //     foreach ($materialAction as $key => $action) {
    //         foreach ($detailWarehouse as $key => $detail) {
    //             if($action->id_material_detail == $detail->id_material_detail){
    //                 $inventory = new Inventory();
    //                 $inventory->id_material_detail = $detail->id_material_detail;
    //                 $inventory->id_unit = $action->$detail->id_unit;
    //                 $inventory->qty = $detail->qty - $action->qty;
    //                 $inventory->save();
    //             }
    //         }
    //     }
    // }
}
