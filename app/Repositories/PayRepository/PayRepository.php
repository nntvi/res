<?php
namespace App\Repositories\PayRepository;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetailTable;
use App\Shift;
use Carbon\Carbon;

class PayRepository extends Controller implements IPayRepository{

    public function findOrder($id)
    {
        $idBillTable = Order::where('id',$id)->with('table.getArea','shift')->first();
        return $idBillTable;
    }

    public function createBill($id)
    {
        $bill = OrderDetailTable::selectRaw('id_dish, sum(qty) as amount')
                                ->where('id_bill',$id)
                                ->whereIn('status',['1','2'])
                                ->groupBy('id_dish')
                                ->with('dish')->get();
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

    public function checkShift($timeUpdate)
    {
        $idShift = Shift::where([
            ['hour_start', '<=', $timeUpdate],
            ['hour_end', '>=', $timeUpdate],
        ])->value('id');
        return $idShift;
    }
    public function updateStatusOrder($request,$id) // thanh toán
    {
        $bill = Order::find($id);
        $bill->total_price = $request->total;
        $bill->receive_cash = $request->receiveCash;
        $bill->excess_cash = $request->excessCash;
        $bill->note = $request->note;
        $bill->status = '0';
        $bill->payer = auth()->user()->name;
        $bill->save();
        return redirect(route('pay.bill',['id' => $id]));
    }

    public function printBill($id)
    {
        $bill = $this->findOrder($id);
        $billPayment = $this->createBill($id);
        $temp = array();
        foreach ($billPayment as $key => $item) {
            $obj = [
                'STT' => $key + 1,
                'Tên món' =>  $item->dish->name,
                'Số lượng' => $item->amount,
                'Đơn giá' => number_format($item->dish->sale_price) . ' đ',
                'Thành tiền' => number_format($item->dish->sale_price * $item->amount) . ' đ'
            ];
            array_push($temp,$obj);
        }
        return view('pay.bill',compact('billPayment','bill','temp'));
    }
}
