<?php
namespace App\Repositories\OrderRepository;

interface IOrderRepository{
    function getArea();
    function getTable($id);
}
