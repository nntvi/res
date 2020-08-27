<?php
namespace App\Repositories\VoucherRepository;

interface IVoucherRepository{
    function checkRoleIndex($arr);
    function checkRoleStore($arr);
    function getCookById($idCook);
    function showIndex();
    function objectPayment($request);
    function validatorStorePaymentVc($request);
    function createPaymentVoucher($request);
    function createPaymentVcEmergency($request);
    function createArrayEmer($arr,$idCook);
}
