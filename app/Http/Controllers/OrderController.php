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
use Pusher\Pusher;

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

    public function deleteDish($idDishOrder)
    {
        $this->orderRepository->destroyDish($idDishOrder);
        return redirect(route('order.index'))->withSuccess('Hủy món thành công');
    }

    public function deleteOrderTable($idOrderTable)
    {
        $countDish = $this->orderRepository->countDishCookingorFinish($idOrderTable);
        if ($countDish > 0) {
            return redirect(route('order.index'))->withErrors('Bàn có món đang/đã thực hiện. Không thể hủy');
        } else {
            $idDishOrder = OrderDetailTable::where('id_bill',$idOrderTable)->get();
            $this->orderRepository->loopDishOrdertoDestroy($idDishOrder);
            Order::where('id',$idOrderTable)->update(['status' => '-1']);
            return redirect(route('order.index'))->withSuccess('Hủy bàn thành công');
        }

    }
    public function showBill()
    {
        $bills = Order::with('table','user','shift','orderDetail.dish')->orderBy('created_at','desc')->paginate(10);
        return view('bill.index',compact('bills'));
    }

    public function filterBill(Request $request)
    {
        $type = $request->typeFilter;
        switch ($type) {
            case 0:
                $bills = Order::with('table','user','shift','orderDetail.dish')->orderBy('created_at','asc')->paginate(10);
                return view('bill.arrange',compact('bills'));
                break;
            case 1:
                $bills = Order::with('table','user','shift','orderDetail.dish')->orderBy('total_price','asc')->paginate(10);
                return view('bill.arrange',compact('bills'));
                break;
            case 2:
                $bills = Order::with('table','user','shift','orderDetail.dish')->orderBy('id_shift','asc')->paginate(10);
                return view('bill.arrange',compact('bills'));
                break;
            default:
        }
    }

    public function searchBill(Request $request)
    {
        $count = Order::selectRaw('count(code) as qty')->where('code','LIKE',"%{$request->searchBill}%")->orWhere('total_price','LIKE',"%{$request->searchBill}")->value('qty');
        $bills = Order::where('code','LIKE',"%{$request->searchBill}%")->orWhere('total_price','LIKE',"%{$request->searchBill}")
                ->with('table','user','shift','orderDetail.dish')->paginate(10);
        return view('bill.search',compact('bills','count'));
    }
}
