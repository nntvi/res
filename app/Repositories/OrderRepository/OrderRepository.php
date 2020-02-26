<?php
namespace App\Repositories\OrderRepository;

use App\Http\Controllers\Controller;
use App\Area;
use App\Table;

class OrderRepository extends Controller implements IOrderRepository{
    public function getArea()
    {
        $areas = Area::orderBy('name')->get();
        return $areas;
    }
    public function getTable($id)
    {
        $tables = Table::where('id_area',$id)->get();
        return $tables;
    }
}
