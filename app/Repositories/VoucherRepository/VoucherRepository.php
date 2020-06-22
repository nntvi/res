<?php
namespace App\Repositories\VoucherRepository;

use App\CookArea;
use App\Http\Controllers\Controller;
use App\ImportCoupon;
use App\Supplier;
use App\PaymentVoucher;
use App\PaymentVoucherDetail;
use App\User;
use App\TypePayment;
use App\WarehouseCook;

class VoucherRepository extends Controller implements IVoucherRepository{

    public function showIndex()
    {
        $suppliers = Supplier::all();
        $payments = PaymentVoucher::with('detailPaymentVc')->paginate(10);
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
                $cooks = CookArea::where('status','1')->get();
                return view('voucher.cookemergency',compact('cooks'));
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

    public function getCookById($idCook)
    {
        $name = CookArea::where('id',$idCook)->value('name');
        return $name;
    }
    public function getImportCouponsByTime($request)
    {
        $importCoupons = ImportCoupon::whereBetween('created_at',[$request->dateStart,$request->dateEnd])
                                    ->where('id_supplier',$request->idSupplierChoosen)->orderBy('created_at','asc')->get();
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

    public function createNewPaymentVoucher($request)
    {
        $paymentVc = new PaymentVoucher();
        $paymentVc->code = $request->code;
        $paymentVc->type = $request->type;
        $paymentVc->name = $request->type == '1' ? $this->getNameSupplierById($request->idSupplierChoosen) : $this->getCookById($request->idCook);
        $paymentVc->pay_cash = $request->pay_cash;
        $paymentVc->note = $request->note;
        $paymentVc->created_by = auth()->user()->name;
        $paymentVc->save();
        return $request->type == '1' ? $paymentVc->pay_cash : $paymentVc->id;
    }
    public function createPaymentVoucher($request)
    {
        $payCash = $this->createNewPaymentVoucher($request);
        $this->updateImportCoupon($this->getImportCouponsByTime($request),$payCash);
        return redirect(route('voucher.index'))->withSuccess("Tạo phiếu chixxxxx  thành công");
    }

    public function addWarehouseCook($idCook,$idMaterialDetail,$qty)
    {
        $nowQty = WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetail)->value('qty');
        WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetail)->update(['qty' => $nowQty + $qty]);
    }
    public function createPaymentVcEmergency($request)
    {
        $idCook = $request->idCook;
        $idPaymentVC = $this->createNewPaymentVoucher($request);
        $count = count($request->idMaterialDetail);
        for ($i=0; $i < $count; $i++) {
            $detailPaymentEmer = new PaymentVoucherDetail();
            $detailPaymentEmer->id_paymentvc = $idPaymentVC;
            $detailPaymentEmer->id_material_detail = $request->idMaterialDetail[$i];
            $detailPaymentEmer->qty = $request->qty[$i];
            $detailPaymentEmer->save();
            $this->addWarehouseCook($idCook,$detailPaymentEmer->id_material_detail,$detailPaymentEmer->qty);
        }
        return redirect(route('voucher.index'))->withSuccess("Tạo phiếu chi thành công");
    }
}
