<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\VoucherRepository\IVoucherRepository;

class VoucherController extends Controller
{
    private $voucherRepository;

    public function __construct(IVoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        return $this->voucherRepository->showIndex();
    }

    public function chooseObject(Request $request)
    {
        return $this->voucherRepository->objectPayment($request);
    }

    public function storePayment(Request $request)
    {
        $this->voucherRepository->validatorStorePaymentVc($request);
        return $this->voucherRepository->createPaymentVoucher($request);
    }

    public function storePaymentEmergency(Request $request)
    {
        return $this->voucherRepository->createPaymentVcEmergency($request);
    }
}
