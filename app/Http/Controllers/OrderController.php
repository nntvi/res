<?php

namespace App\Http\Controllers;

use App\Area;
use App\Dishes;
use App\GroupMenu;
use App\Order;
use App\OrderDetailTable;
use App\Table;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository\IOrderRepository;
use App\Topping;
use Carbon\Carbon;

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
        $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $idOrders = Order::whereBetween('created_at',[$date . ' 00:00:00', $date . ' 23:59:59'])
                        ->with('table.getArea')->get();
        return view('order.index',compact('areas','idOrders'));
    }

    public function orderTable()
    {
        $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

        $product_ids = Order::whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])
                            ->where('status', '1')->get('id_table');
        $tables = Table::whereNotIn('id', $product_ids)->get();
        // dd($tables);
        $groupmenus = $this->orderRepository->getDishes();
        return view('order.orderTable',compact('groupmenus','tables'));
    }

    public function orderTablePost(Request $request)
    {
        $orderTable = new Order();
        $orderTable->id_table = $request->idTable;
        $orderTable->status = '1'; // đang order, chưa thanh toán
        $orderTable->save();

        $idDishes = $request->idDish;
        foreach ($idDishes as $key => $id) {
            $price = Dishes::where('id',$id)->first();
            $data = [
                'id_bill' => $orderTable->id,
                'qty' => 1,
                'id_dish' => $id,
                'price' => $price->sale_price
            ];
           OrderDetailTable::create($data);
        }

        return redirect(route('order.update',['id' => $orderTable->id]));
    }

    public function viewUpdate($id)
    {
        $idBill = $id;
        $orderById = Order::where('id',$id)->with('orderDetail.dish','table.getArea')->get();
        return view('order.update',compact('orderById','idBill'));
    }

    public function update(Request $request, $id)
    {
        $detailOrder = OrderDetailTable::find($id);
        $detailOrder->qty = $request->qty;
        $detailOrder->note = $request->note;
        $detailOrder->save();
        return redirect(route('order.update',['id' => $detailOrder->id_bill]));
    }

    public function viewaddMoreDish($id)
    {
        $groupmenus = GroupMenu::with('dishes')->get();
        $order = Order::where('id',$id)->with('table')->first();
        return view('order.addmoredish',compact('groupmenus','order'));
    }

    public function addMoreDish(Request $request, $id)
    {
        $dataIdDish = $request->idDish;
        foreach ($dataIdDish  as $key => $value) {
            $price = Dishes::where('id',$value)->first();
                $data = [
                    'id_bill' => $id,
                    'qty' => 1,
                    'price' => $price->sale_price,
                    'id_dish' => $value
                ];
            OrderDetailTable::create($data);
        }
       return redirect(route('order.update',['id' => $id]));
    }

    public function deleteDish($id)
    {
        $idBill = OrderDetailTable::find($id)->first('id_bill');
        OrderDetailTable::find($id)->delete();
        return redirect(route('order.update',['id' => $idBill->id_bill]));
    }
}
