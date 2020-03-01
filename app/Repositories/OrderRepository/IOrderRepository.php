<?php
namespace App\Repositories\OrderRepository;

interface IOrderRepository{
    function getArea();
    function getDishes();
    function postOrder($request, $id);
}
