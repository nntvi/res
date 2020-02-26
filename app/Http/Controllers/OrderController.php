<?php

namespace App\Http\Controllers;

use App\Area;
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

    public function index()
    {
        $areas = $this->orderRepository->getArea();
        return view('order.index',compact('areas'));
    }

    // public function getTable($id)
    // {
    //     $tables = Table::where('id_area',$id)->get();
    //     return redirect(route('order.index',compact('tables')));
    // }
}
