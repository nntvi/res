<?php
namespace App\Repositories\VoucherRepository;

use App\Http\Controllers\Controller;
use App\ImportCoupon;
use App\Supplier;
use App\PaymentVoucher;
use App\User;
use App\TypePayment;
class VoucherRepository extends Controller implements IVoucherRepository{

    public function showIndex()
    {
        $suppliers = Supplier::all();
        $payments = PaymentVoucher::paginate(10);
        return view('voucher.index',compact('suppliers','payments'));
    }

    public function objectPayment($request)
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

    public function validatorStorePaymentVc($request)
    {
        $request->validate(
            ['code' => 'unique:payment_voucher,code'],
            ['code.unique' => 'Mã phiếu chi đã tồn tại trong hệ thống']
        );
    }
    public function getNameSupplierById($idSupplier)
    {
        $name = Supplier::where('id',$idSupplier)->value('name');
        return $name;
    }

    public function getImportCouponsByTime($request)
    {
        $importCoupons = ImportCoupon::whereBetween('created_at',[$request->dateStart,$request->dateEnd])
                                    ->where('id_supplier',$request->idSupplierChoosen)
                                    ->orderBy('created_at','asc')->get();
        return $importCoupons;
    }

    public function updateImportCoupon($arrImportCoupons,$payCash)
    {
        $temp = $payCash;
        foreach ($arrImportCoupons as $key => $item) {
            if($temp >= $item->total){
                $item->paid = $item->total;
                $item->status = '2'; // trả hết
                $item->save();
                $temp -= $item->total;
            }else if($temp < $item->total){
                $item->paid = $temp;
                $item->status = '1'; // trả một ít
                $item->save();
                $temp = 0;
            }else if($temp == 0){
                break;
            }
        }
    }

    public function createPaymentVoucher($request)
    {
        $paymentVc = new PaymentVoucher();
        $paymentVc->code = $request->code;
        $paymentVc->type = $request->type;
        $paymentVc->name = $this->getNameSupplierById($request->idSupplierChoosen);
        $paymentVc->pay_cash = $request->pay_cash;
        $paymentVc->note = $request->note;
        $paymentVc->created_by = auth()->user()->name;
        $paymentVc->save();
        $this->updateImportCoupon($this->getImportCouponsByTime($request),$paymentVc->pay_cash);
        return redirect(route('voucher.index'))->withSuccess("Tạo phiếu chi thành công");
    }
}
