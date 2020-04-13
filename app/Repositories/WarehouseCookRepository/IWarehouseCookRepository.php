<?php
namespace App\Repositories\WarehouseCookRepository;

interface IWarehouseCookRepository{
    function getMaterialFromCook();
    function addMaterial($data,$cookwarehouse);
    function createWarehouseCook();
    function getCookWarehouse();
    function showWarehouseCook();
    function resetWarehouseCook();
}
