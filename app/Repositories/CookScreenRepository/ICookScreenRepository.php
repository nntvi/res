<?php
namespace App\Repositories\CookScreenRepository;

interface ICookScreenRepository{
    function getAllCookArea();
    function getDetailCookScreen($id);
    function updateStatusWarehouseCook($idMaterial,$idCook);
    function updateStatusDish($request,$id,$idCook);
}
