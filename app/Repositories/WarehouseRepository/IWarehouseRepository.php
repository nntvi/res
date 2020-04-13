<?php
namespace App\Repositories\WarehouseRepository;

interface IWarehouseRepository{
    function showIndex();
    function updateLimitStockWarehouse($request,$id);
    function reportWarehouse($request);
    function getDetailReport($id,$dateStart,$dateEnd);
}
