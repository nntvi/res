<?php
namespace App\Repositories\AjaxRepository;

interface IAjaxRepository{
    function getDateTime($id);
    function getMaterialBySupplier($idSupplier);
    function getMaterialByIdPlan($idPlan);
    function getDishToSearch($name);
    function getUnit();
    function getMaterialWarehouseCook($idCook);
    function getIdMaterialByIdCook($materials);
    function findMaterialInWarehouse($idMaterialArray);
    function getMaterialInWarehouseByType($type);
    function getMaterialByIdType($idType);
    function getMaterialOfDish($idGroupNVL);
    function createArrayMethodForDish($materialDetails,$materialOfDish);
    function searchMaterialDestroy($name);
    function searchMaterialDestroyCook($id,$name);
    function getCapitalPriceByIdMaterial($idMaterial);
    function getRevenue($dateStart,$dateEnd);
    function countPaidBill($dateStart,$dateEnd);
    function countServingBill($dateStart,$dateEnd);
    function countBill($dateStart,$dateEnd);
    function getImportCouponToCreatePaymentVoucher($dateStart,$dateEnd,$idSupplier);
    function getConcludeImportCoupon($coupons);
    function getExpense($dateStart,$dateEnd);
    function getAllQtyCustomer($time);

    // test report dish
    function getOrderByAllGroupMenu($dateStart,$dateEnd);
    function getOrderByIdGroupMenu($dateStart,$dateEnd,$idGroupMenu);

    function getCapitalPriceOfDish($dateStart,$dateEnd);
    function getTotalPayment($dateStart,$dateEnd);
    function getPayReturnSupplier($dateStart,$dateEnd);
}
