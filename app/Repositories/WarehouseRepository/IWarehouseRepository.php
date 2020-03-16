<?php
namespace App\Repositories\WarehouseRepository;

interface IWarehouseRepository{
    function getListImport();
    function getSuppliers();
    function getMaterialDetail();
    function getUnit();
    function showIndex();
    function showViewImport();
    function countMaterialImport($request);
    function createWarehouseDetail();
    function createWarehouse();
    function importWarehouse($request);
    function findDetailWarehouseById($id);
    function updateDetailWarehouse($request,$id);
    function getDetailWarehouseByCode($code);
    function findWarehouseByCode($code);
    function findDetailWarehouseByCode($code);
    function printDetailByCode($code);
}
