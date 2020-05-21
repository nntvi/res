<?php

namespace App\Http\Controllers;

use App\Area;
use App\Dishes;
use App\GroupMenu;
use App\Inventory;
use App\MaterialAction;
use App\Order;
use App\OrderDetailTable;
use App\Table;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository\IOrderRepository;
use App\Topping;
use App\WareHouseDetail;
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
        return $this->orderRepository->showTableInDay();
    }

    public function orderTable()
    {
        return $this->orderRepository->orderTable();
    }

    public function orderTablePost(Request $request)
    {
        //$this->orderRepository->validatorOrder($request);
        return $this->orderRepository->orderTablePost($request);
    }

    public function viewUpdate($id)
    {
        $orderById = Order::where('id',$id)->with('orderDetail.dish','table.getArea')->get();
        return view('order.update',compact('orderById'));
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

    public function addMoreDish(Request $request, $idOrderTable)
    {
        return $this->orderRepository->addMoreDish($request,$idOrderTable);
    }

    public function deleteDish($id)
    {
        $idBill = OrderDetailTable::find($id)->value('id_bill');
        OrderDetailTable::find($id)->delete();
        return redirect(route('order.update',['id' => $idBill]));
    }

    public function showBill()
    {
        $bills = Order::with('table','user','shift','orderDetail.dish')->orderBy('created_at','asc')->paginate(5);
        return view('bill.index',compact('bills'));
    }

    public function filterBill(Request $request)
    {
        $type = $request->typeFilter;
        switch ($type) {
            case 0:
                $bills = Order::with('table','user','shift','orderDetail.dish')->orderBy('created_at','asc')->paginate(5);
                return view('bill.arrange',compact('bills'));
                break;
            case 1:
                $bills = Order::with('table','user','shift','orderDetail.dish')->orderBy('total_price','asc')->paginate(5);
                return view('bill.arrange',compact('bills'));
                break;
            case 2:
                $bills = Order::with('table','user','shift','orderDetail.dish')->orderBy('id_shift','asc')->paginate(5);
                return view('bill.arrange',compact('bills'));
                break;
            default:
        }
    }

    public function searchBill(Request $request)
    {
        $search = $request->searchBill;
        $bills = Order::where('id','LIKE',"%{$search}%")->with('table','user','shift','orderDetail.dish')->paginate(10);
        return view('bill.search',compact('bills'));
    }
}
