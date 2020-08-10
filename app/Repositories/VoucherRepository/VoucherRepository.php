<?php
namespace App\Repositories\VoucherRepository;

use App\User;
use App\EndDay;
use App\CookArea;
use App\StartDay;
use App\Supplier;
use Carbon\Carbon;
use App\TypePayment;
use App\ImportCoupon;
use App\HistoryWhCook;
use App\WarehouseCook;
use App\PaymentVoucher;
use App\PaymentVoucherDetail;
use App\Http\Controllers\Controller;

class VoucherRepository extends Controller implements IVoucherRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL"){
                $temp++;
            }
        }
        return $temp;
    }

    public function showIndex()
    {
        $payments = PaymentVoucher::with('detailPaymentVc')->orderBy('created_at','desc')->get();
        return view('voucher.index',compact('payments'));
    }

    public function generate_string($input,$strength,$random_string) {
        $input_length = strlen($input);
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

    public function createCode($random_string)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $code = $this->generate_string($permitted_chars,5,$random_string);
        return $code;
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
                $code = $code = $this->createCode("PCB");
                return view('voucher.cookemergency',compact('cooks','code'));
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
        $temp = $payCash; // số tiền nhập vào
        foreach ($arrImportCoupons as $key => $item) {
            if($item->status == '2'){ // có phiếu đã trả hết
                continue;
            }else{ // trả 1 ít hoặc chưa trả
                if($temp >= $item->total){ // tiền nhập trả >= phiếu
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
    }

    public function createNewPaymentVoucher($request)
    {
        $paymentVc = new PaymentVoucher();
        $paymentVc->code = $request->code;
        $paymentVc->type = $request->type;
        // chi bếp khẩn or chi trả cho ncc - type 1 = nccc, 2: bếp
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
        return redirect(route('voucher.index'))->withSuccess("Tạo phiếu chi thành công");
    }

    public function addWarehouseCook($idCook,$idMaterialDetail,$qty)
    {
        $nowQty = WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetail)->value('qty');
        WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetail)->update(['qty' => $nowQty + $qty]);
    }

    public function checkStartDay()
    {
        $nowDay = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $value = StartDay::where('date',$nowDay)->value('date');
        return $value;
    }

    public function checkEndDay()
    {
        $nowDay = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $value = EndDay::where('date',$nowDay)->value('id');
        return $value;
    }

    public function plusQtyHistoryCook($idCook,$idMaterialDetail,$qty)
    {
        $s = " 00:00:00"; $e = " 23:59:59";
        $checkStartDay = $this->checkStartDay();
        $checkEndDay = $this->checkEndDay();
        if($checkStartDay != null && $checkEndDay == null){ // đã khai ca và chưa chốt ca ngày đó
            $tempQty = HistoryWhCook::where('id_cook',$idCook)->where('id_material_detail',$idMaterialDetail)
                        ->whereBetween('created_at',[$checkStartDay . $s, $checkStartDay . $e])->value('first_qty');
            HistoryWhCook::where('id_cook',$idCook)->where('id_material_detail',$idMaterialDetail)
                        ->whereBetween('created_at',[$checkStartDay . $s, $checkStartDay . $e])->update(['first_qty' => $tempQty + $qty]);
        }
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
            $this->plusQtyHistoryCook($idCook,$request->idMaterialDetail[$i],$request->qty[$i]);
        }
        return redirect(route('voucher.index'))->withSuccess("Tạo phiếu chi thành công");
    }
}
