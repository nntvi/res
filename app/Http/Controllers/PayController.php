<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetailTable;
use App\Repositories\PayRepository\IPayRepository;
use Illuminate\Http\Request;
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
