<?php
namespace App\Repositories\WarehouseCookRepository;

interface IWarehouseCookRepository{
    function checkRoleIndex($arr);
    function checkRoleUpdate($arr);

    function getMaterialFromCook();
    function addMaterial($data,$cookwarehouse);
    function createWarehouseCook();
    function getCookWarehouse();
    function showWarehouseCook();
    function resetWarehouseCook();
    function reportWarehouseCook($request);
}
