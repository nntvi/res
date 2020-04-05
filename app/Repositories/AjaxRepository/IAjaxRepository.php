<?php
namespace App\Repositories\AjaxRepository;

interface IAjaxRepository{
    function getUnit();
    function getMaterialBySupplier($idSupplier);
    function getMaterialWarehouseCook($idCook);
    function getIdMaterialByIdCook($materials);
    function findMaterialInWarehouse($idMaterialArray);
    function getTypeByIdSupplier($idSupplier);
    function getMaterialInWarehouseByType($type);
    function getAllWarehouseToDestroy();
    function getTypeMaterial();
    function getDateNow();
    function getWeek();
    function getMonth();
    function getYear();
    function warehouseBetweenTime($dateStart,$dateEnd);
    function importBetween($dateStart,$dateEnd);
    function exportBetween($dateStart,$dateEnd);
}
