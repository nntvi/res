<?php
namespace App\Repositories\OrderRepository;

interface IOrderRepository{
    function getArea();
    function getDishes();
    function showTableInDay();
    function orderTable();
    function orderTablePost($request);
    function addMoreDish($request,$idOrderTable);
    function validatorOrder($request);
}
