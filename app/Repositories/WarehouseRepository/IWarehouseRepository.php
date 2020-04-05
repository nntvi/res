<?php
namespace App\Repositories\WarehouseRepository;

interface IWarehouseRepository{
    function showIndex();
    function reportWarehouse($request);
    function getDetailReport($id,$dateStart,$dateEnd);
}
