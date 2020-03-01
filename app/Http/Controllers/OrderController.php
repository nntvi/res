<?php

namespace App\Http\Controllers;

use App\Area;
use App\Order;
use App\OrderDetailTable;
use App\Table;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository\IOrderRepository;

class OrderController extends Controller
{
    private $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function showTable()
    {
        $areas = $this->orderRepository->getArea();
        $tableOrders = Order::all();
        return view('order.index',compact('areas','tableOrders'));
    }




    public function orderTable($id)
    {
        $table = Table::where('id',$id)->get();
        $groupmenus = $this->orderRepository->getDishes();
        return view('order.orderTable',compact('table','groupmenus'));
    }

    public function orderTablePost(Request $request, $id)
    {
        $orderTable = new Order();
        $orderTable->id_table = $id;
        $orderTable->status = '1'; // đang order, chưa thanh toán
        $orderTable->save();

        $orderDetail = $request->idDish;
        foreach ($orderDetail as $key => $id) {
           $data = [
                'id_bill' => $orderTable->id,
                'qty' => 1,
                'id_dish' => $id
           ];
           OrderDetailTable::create($data);
        }
        return redirect(route('order.update',['id' => $orderTable->id]));
    }

    public function viewUpdate($id)
    {
        $orderById = Order::where('id',$id)->with('orderDetail.dish','table')->get();
        // dd($orderById);
        return view('order.update',compact('orderById'));
    }

    public function update(Request $request, $id)
    {
        $detailOrder = OrderDetailTable::find($id);
        $detailOrder->qty = $request->qty;
        $detailOrder->price = $request->price;
        $detailOrder->save();
        return redirect(route('order.update',['id' => $detailOrder->id_bill]));
    }
}
