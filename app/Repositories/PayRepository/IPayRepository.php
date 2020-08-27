<?php
namespace App\Repositories\PayRepository;

interface IPayRepository{
    function findOrder($id);
    function createBill($id);
    function getTotalBill($bill);
    function showBill($id);
    function updateStatusOrder($request,$id);
    function printBill($id);
}
