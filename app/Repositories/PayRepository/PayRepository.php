<?php
namespace App\Repositories\PayRepository;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetailTable;

class PayRepository extends Controller implements IPayRepository{

    public function findOrder($id)
    {
        $idBillTable = Order::where('id',$id)->with('table')->first();
        return $idBillTable;
    }

    public function createBill($id)
    {
        $bill = OrderDetailTable::selectRaw('id_dish, sum(qty) as amount')
                                ->where('id_bill',$id)
                                ->whereIn('status',['1','2'])
                                ->groupBy('id_dish')
                                ->with('dish')
                                ->get();
        return $bill;
    }

    public function getTotalBill($bill)
    {
        $totalPrice = 0;
        foreach ($bill as $value) {
           $totalPrice += $value->amount * $value->dish->sale_price;
        }
        return $totalPrice;
    }

    public function countStatus($idBill)
    {
        $count = OrderDetailTable::where('id_bill',$idBill)
                                    ->whereIn('status', ['1', '2'])
                                    ->count();
        return $count;
    }
    public function showBill($id)
    {
        $idBillTable = $this->findOrder($id);
        $bill = $this->createBill($id);
        $totalPrice = $this->getTotalBill($bill);
        $count = $this->countStatus($id);
        return view('pay.index',compact('idBillTable','bill','totalPrice','count'));
    }

    public function updateStatusOrder($request,$id)
    {
        $bill = Order::find($id);
        $bill->total_price = $request->total;
        $bill->receive_cash = $request->receiveCash;
        $bill->excess_cash = $request->excessCash;
        $bill->note = $request->note;
        $bill->status = '0';
        $bill->save();

        $total = $this->findOrder($id);
        $billPayment = $this->createBill($id);

        return view('pay.print',compact('billPayment','total'));
    }
}
