<?php

namespace App\Http\Controllers;

use App\User;
use App\Supplier;
use App\TypePayment;
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
        $object = $request->object;
        switch ($object) {
            case 1:
                $suppliers = Supplier::all();
                return view('voucher.storepayment',compact('suppliers'));
                break;
            case 2:
                $types = TypePayment::whereNotIn('id',[1])->get();
                $users = User::all();
                return view('paymentvoucher.otherstore',compact('types','users'));
                break;
            default:
        }
    }

    public function storePayment(Request $request)
    {
        # code...
    }
}
