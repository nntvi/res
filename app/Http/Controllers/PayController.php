<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetailTable;
use Illuminate\Http\Request;
class PayController extends Controller
{
    public function index($id)
    {
        $idBillTable = Order::where('id',$id)->with('table')->first();
        $bill = OrderDetailTable::selectRaw('id_dish, sum(qty) as amount')
                                ->where('id_bill',$id)
                                ->where('status','=','1')
                                ->orWhere('status','=','2')
                                ->groupBy('id_dish')
                                ->with('dish')
                                ->get();
        //dd($bill);
        $totalPrice = 0;
        foreach ($bill as $value) {
           $totalPrice += $value->amount * $value->dish->sale_price;
        }
        //echo $totalPrice;
        return view('pay.index',compact('idBillTable','bill','totalPrice'));
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
                                ->where('status','=','1')
                                ->orWhere('status','=','2')
                                ->groupBy('id_dish')
                                ->with('dish')
                                ->get();

        return view('pay.print',compact('billPayment','total'));
    }
}
