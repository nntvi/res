<?php
namespace App\Repositories\VoucherRepository;

interface IVoucherRepository{
    function showIndex();
    function objectPayment($request);
    function validatorStorePaymentVc($request);
    function createPaymentVoucher($request);
}
