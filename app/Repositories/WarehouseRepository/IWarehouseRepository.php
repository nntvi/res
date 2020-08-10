<?php
namespace App\Repositories\WarehouseRepository;

interface IWarehouseRepository{
    function checkRoleIndex($arr);
    function checkRoleUpdate($arr);

    function showIndex();
    function updateLimitStockWarehouse($request,$id);
    function reportWarehouse($request);
    function getDetailReport($id,$dateStart,$dateEnd);
}
