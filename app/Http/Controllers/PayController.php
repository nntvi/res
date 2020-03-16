<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetailTable;
<<<<<<< HEAD
use App\MaterialAction;
use App\Dishes;
use App\Inventory;
use App\WareHouseDetail;
=======
use App\Repositories\PayRepository\IPayRepository;
>>>>>>> f14c71721dd67eb27b808c9a9fb48a742c686946
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
<<<<<<< HEAD
        $idBillTable = Order::where('id',$id)->with('table')->first();
        $bill = OrderDetailTable::selectRaw('id_dish, sum(qty) as amount')
                                ->where('id_bill',$id)
                                ->whereIn('status',['1','2'])
                                ->groupBy('id_dish')
                                ->with('dish')
                                ->get();
        //dd($bill);
        $totalPrice = 0;
        foreach ($bill as $value) {
           $totalPrice += $value->amount * $value->dish->sale_price;
        }
        return view('pay.index',compact('idBillTable','bill','totalPrice'));
=======
        return $this->payRepository->showBill($id);
>>>>>>> f14c71721dd67eb27b808c9a9fb48a742c686946
    }

    public function update(Request $request, $id)
    {
        $bill = Order::find($id);
        $bill->total_price = $request->total;
        $bill->note = $request->note;
        $bill->status = '0';
        $bill->save();


        $total = Order::where('id',$id)->first();
        $billPayment = OrderDetailTable::selectRaw('id_dish, sum(qty) as amount')
                                ->where('id_bill',$id)
                                ->whereIn('status',['1','2'])
                                ->groupBy('id_dish')
                                ->with('dish')
                                ->get();
        //dd($billPayment);
        //$this->substract($billPayment);
        return view('pay.print',compact('billPayment','total'));
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
