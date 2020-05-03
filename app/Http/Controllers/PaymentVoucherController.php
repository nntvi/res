<?php

namespace App\Http\Controllers;

use App\PaymentVoucher;
use App\Supplier;
use App\TypePayment;
use App\User;
use Illuminate\Http\Request;

class PaymentVoucherController extends Controller
{
    public function index()
    {
        $vouchers = PaymentVoucher::
        return view('paymentvoucher.index');
    }

    public function chooseObject(Request $request)
    {
        $object = $request->object;
        switch ($object) {
            case 1:
                $suppliers = Supplier::all();
                return view('paymentvoucher.supplierstore',compact('suppliers'));
                break;
            case 2:
                $types = TypePayment::whereNotIn('id',[1])->get();
                $users = User::all();
                return view('paymentvoucher.otherstore',compact('types','users'));
                break;
            default:
        }
    }

    public function storeOther(Request $request)
    {
        $paymentVc = new PaymentVoucher();
        $paymentVc->code = $request->codePayment;
        $paymentVc->type_payment = $request->typePayment;
        $paymentVc->name = $request->receiver;
        $paymentVc->content = $request->content;
        $paymentVc->created_by = $request->idUser;
        $paymentVc->total = $request->money;
        $paymentVc->save();
        return redirect(route('paymentvoucher.index'));
    }
}
