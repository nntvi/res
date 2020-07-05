<?php
namespace App\Repositories\CookScreenRepository;

interface ICookScreenRepository{
    function getDishByIdDishOrder($idDishOrder);
    function getAllCookArea();
    function checkRoleDetail($results);
    function getDetailCookScreen($id);
    function updateStatusWarehouseCook($idMaterial,$idCook);
    function updateFinishDish($idDishOrder,$idCook,$idMaterialDetails,$qtyMethods,$qtyReals,$dish);
    function getIdDishByIdDishOrder($idDishOrder);
    function findIdGroupNVL($idDish);
    function getIdCookByGroupNVL($idGroupNVL);
    function getOnlyIdMaterialAction($idGroupNVL);
    function getQtyDishOrderByIdDishOrder($idDishOrder);
    function findInWarehouseCook($idCook,$idMaterialDetails);
    function findInWarehouse($idMaterialDetails);
    function compareWarehouseCook($materialInWarehouseCooks,$materialInActions,$qtyOrder);
    function getMaterialAction($idGroupNVL);
    function compareWarehouse($materialInWarehouse,$materialInActions,$qtyNotEnough);
    function createDishEmptyCook($dishOrder,$qtyEmptyCook,$idCook);
    function createDishEmptyWh($dishOrder,$qtyEmptyWh,$idCook);
    function validateToCook($request);

    function updateStatusDish($idDishOrder,$idCook,$dishOrder,$qty,$status);
}
