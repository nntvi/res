<?php

namespace App\Http\Controllers;

use App\Area;
use App\Dishes;
use App\GroupMenu;
use App\Inventory;
use App\MaterialAction;
use App\Order;
use App\OrderDetailTable;
use App\OrderTable;
use App\Table;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository\IOrderRepository;
use App\Topping;
use App\WareHouseDetail;
use Carbon\Carbon;
use Pusher\Pusher;
use App\Helper\ICheckAction;

class OrderController extends Controller
{
    private $orderRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IOrderRepository $orderRepository)
    {
        $this->checkAction = $checkAction;
        $this->orderRepository = $orderRepository;
    }

    public function showTable()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->orderRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->orderRepository->showTableInDay();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function orderTable()
    {
        return $this->orderRepository->orderTable();
    }

    public function orderTablePost(Request $request)
    {
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
            OrderTable::where('id_order',$idOrderTable)->update(['status' => '-1']);
            return redirect(route('order.index'))->withSuccess('Hủy bàn thành công');
        }
    }

    public function matchTable(Request $request,$idBill)
    {
        $idTableMatch = $request->idMatchTables;
        $length = $request->lengthMatchTable;
        for ($i=0; $i < $length; $i++) {
            $this->orderRepository->saveTable($idBill,$idTableMatch[$i]);
        }
        return redirect(route('order.index'));
    }

    public function destroyTable(Request $request,$idBill)
    {
        $idDestroyTables = $request->idDestroyTables;
        $length = $request->lengthDestroyTables;
        $countTableMatchOrder = OrderTable::selectRaw('count(id) as qty')->where('id_order',$idBill)->where('status','1')->value('qty');
        if($length == $countTableMatchOrder){
            $this->deleteOrderTable($idBill);
            return 1;
        }else{
            for ($i=0; $i < $length; $i++) {
                OrderTable::where('id_table',$idDestroyTables[$i])->delete();
            }
            return 0;
        }
    }

    public function showBill()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->orderRepository->checkRoleIndexBill($result);
        if($check != 0){
            $bills = Order::with('tableOrdered.table','user','shift','orderDetail.dish')->orderBy('created_at','desc')->get();
            return view('bill.index',compact('bills'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function getDetailBill($id)
    {
        $detailBill = Order::where('id',$id)->with('tableOrdered.table','user','shift','orderDetail.dish')->first();
        //dd($detailBill);
        return view('bill.detail',compact('detailBill'));
    }
}
