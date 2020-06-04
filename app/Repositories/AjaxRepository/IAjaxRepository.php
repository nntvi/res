<?php
namespace App\Repositories\AjaxRepository;

interface IAjaxRepository{
    function getMaterialBySupplier($idSupplier);
    function getUnit();
    function getMaterialWarehouseCook($idCook);
    function getIdMaterialByIdCook($materials);
    function findMaterialInWarehouse($idMaterialArray);
    function getMaterialInWarehouseByType($type);
    function searchMaterialDestroy($name);
    function searchMaterialDestroyCook($id,$name);
    function getCapitalPriceByIdMaterial($idMaterial);
    function getRevenue($dateStart,$dateEnd);
    function countPaidBill($dateStart,$dateEnd);
    function countServingBill($dateStart,$dateEnd);
    function countBill($dateStart,$dateEnd);
    function getImportCouponToCreatePaymentVoucher($dateStart,$dateEnd,$idSupplier);
    function getConcludeImportCoupon($coupons);
}
