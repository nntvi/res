<?php
namespace App\Repositories\PayRepository;

use App\Dishes;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetailTable;
use App\OrderTable;
use App\Shift;
use Carbon\Carbon;
use Pusher\Pusher;

class PayRepository extends Controller implements IPayRepository{

    public function findOrder($id)
    {
        $idBillTable = Order::where('id',$id)->with('tableOrdered.table.getArea','shift')->first();
        return $idBillTable;
    }

    public function createBill($id)
    {
        $bill = OrderDetailTable::selectRaw('id_dish, sum(qty) as amount')->where('id_bill',$id)
                                ->whereIn('status',['1','2'])->groupBy('id_dish')->with('dish')->get();
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
        $count = OrderDetailTable::where('id_bill',$idBill)->whereIn('status', ['1', '2'])->count();
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

    public function updateStatusTableOrder($idOrder)
    {
        OrderTable::where('id_order',$idOrder)->update(['status' => '0']);
    }

    public function notifyDistroyDish($idDishOrder)
    {
        $dish = Dishes::where('id',$idDishOrder)->with('groupMenu.cookArea')->first();
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
        $data['idCook'] = $dish->groupMenu->cookArea->id;
        $data['nameDish'] = $dish->name;
        $pusher->trigger('NotifyCook', 'notify-cook', $data);
    }

    public function destroyDish($idOrder)
    {
        $dishes = OrderDetailTable::where('id_bill',$idOrder)->where('status','0')->get();
        if(count($dishes) != 0){
            foreach ($dishes as $key => $dish) {
                $dish->status = '-2';
                $dish->save();
                $this->notifyDistroyDish($dish->id_dish);
            }
        }
    }

    public function updateStatusOrder($request,$id) // thanh toán
    {
        $this->destroyDish($id);
        $bill = Order::find($id);
        $bill->total_price = $request->total;
        $bill->receive_cash = $request->receiveCash;
        $bill->excess_cash = $request->excessCash;
        $bill->note = $request->note;
        $bill->status = '0';
        $bill->payer = auth()->user()->name;
        $bill->save();
        $this->updateStatusTableOrder($id);
        return redirect(route('pay.bill',['id' => $id]))->withSuccess('Thanh toán thành công');
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
