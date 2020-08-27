<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\VoucherRepository\IVoucherRepository;
use App\Helper\ICheckAction;
class VoucherController extends Controller
{
    private $voucherRepository;
    private $checkAction;

    public function __construct(ICheckAction $checkAction, IVoucherRepository $voucherRepository)
    {
        $this->checkAction = $checkAction;
        $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->voucherRepository->checkRoleIndex($result);
        if($check != 0){
            return $this->voucherRepository->showIndex();
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function chooseObject(Request $request)
    {
        return $this->voucherRepository->objectPayment($request);
    }

    public function storePayment(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->voucherRepository->checkRoleStore($result);
        if($check != 0){
            $this->voucherRepository->validatorStorePaymentVc($request);
            return $this->voucherRepository->createPaymentVoucher($request);
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function storePaymentEmergency(Request $request)
    {
        $result = $this->checkAction->getPermission(auth()->id());
        $check = $this->voucherRepository->checkRoleStore($result);
        if($check != 0){
            $type = $request->type;
            $code = $request->code;
            $idCook = $request->idCook;
            $nameCook = $this->voucherRepository->getCookById($idCook);
            $note = $request->note;
            $pay_cash = $request->pay_cash;
            $arrEmer = $this->voucherRepository->createArrayEmer($request->idMaterialDetail,$idCook);
            return view('voucher.cookemer2',compact('type','code','idCook','nameCook','note','pay_cash','arrEmer'));
        }else{
            return view('layouts')->withErrors('Bạn không thuộc quyền truy cập chức năng này');
        }
    }

    public function storePaymentEmergencyTemp(Request $request)
    {
        //dd($request->all());
        return $this->voucherRepository->createPaymentVcEmergency($request);
    }
}
