<?php
namespace App\Repositories\OrderRepository;

interface IOrderRepository{
    function checkRoleIndex($arr);
    function checkRoleIndexBill($arr);

    function getArea();
    function getDishes();
    function countDishCookingorFinish($idOrderTable);
    function showTableInDay();
    function saveTable($idOrderTable,$idTable);
    function orderTable();
    function orderTablePost($request);
    function addMoreDish($request,$idOrderTable);
    function validatorOrder($request);
    function destroyDish($idDishOrder);
    function loopDishOrdertoDestroy($arrDishOrder);
}
