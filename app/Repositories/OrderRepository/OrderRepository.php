<?php
namespace App\Repositories\OrderRepository;

use App\Http\Controllers\Controller;
use App\Area;
use App\Dishes;
use App\GroupMenu;
use App\Table;

class OrderRepository extends Controller implements IOrderRepository{
    public function getArea()
    {
        $areas = Area::with('containTable')->get();

        return $areas;
    }

    public function getDishes()
    {
        $groupmenus = GroupMenu::with('dishes')->get();
        return $groupmenus;
    }

    public function postOrder($request, $id)
    {
        # code...
    }
}
