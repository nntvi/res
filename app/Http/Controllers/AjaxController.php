<?php

namespace App\Http\Controllers;

use App\Order;
use App\CookArea;
use App\Supplier;
use App\GroupMenu;
use App\WareHouse;
use Carbon\Carbon;
use App\ImportCoupon;
use App\TypeMaterial;
use App\WarehouseCook;
use App\MaterialDetail;
use App\PaymentVoucher;
use App\OrderDetailTable;
use App\ImportCouponDetail;


use Illuminate\Http\Request;
use App\Repositories\AjaxRepository\IAjaxRepository;

class AjaxController extends Controller
{
    private $ajaxRepository;

    public function __construct(IAjaxRepository $ajaxRepository)
    {
        $this->ajaxRepository = $ajaxRepository;
    }

    public function getMaterialBySupplier($idSupplier)
    {
        $materials = $this->ajaxRepository->getMaterialBySupplier($idSupplier);
        return response()->json($materials);
    }

    public function getMaterialToExportCook($idObjectCook)
    {
        $data = array();
        $materailWarehouseCook = $this->ajaxRepository->getMaterialWarehouseCook($idObjectCook);
        $idMaterialArray = $this->ajaxRepository->getIdMaterialByIdCook($materailWarehouseCook);
        $materialWarehouse = $this->ajaxRepository->findMaterialInWarehouse($idMaterialArray);
        $data = [
            'materialWarehouseCook' => $materailWarehouseCook,
            'materialWarehouse'     => $materialWarehouse
        ];
        return response()->json($data);
    }

    public function getImportCouponByIdSupplier($idSupplier)
    {
        $importCoupons = ImportCoupon::where('id_supplier',$idSupplier)->get();
        return response()->json($importCoupons);
    }

    public function getMaterialByImportCoupon($codeCoupon)
    {
        $materials = ImportCouponDetail::where('code_import',$codeCoupon)->with('materialDetail','unit')->get();
        return response()->json($materials);
    }

    public function searchMaterialDestroy($name)
    {
        $material = $this->ajaxRepository->searchMaterialDestroy($name);
        return response()->json($material);
    }

    public function searchMaterialDestroyCook($id,$name)
    {
        $material = $this->ajaxRepository->searchMaterialDestroyCook($id,$name);
        return response()->json($material);
    }

    public function getCapitalPrice($idMaterial)
    {
        $data = $this->ajaxRepository->getCapitalPriceByIdMaterial($idMaterial);
        return response()->json($data);
    }

    public function getDateTimeToReport($id)
    {
        $data = $this->ajaxRepository->getDateTime($id);
        return response()->json($data);
    }

    public function showOverview($dateStart,$dateEnd)
    {
        $totalRevenue = $this->ajaxRepository->getRevenue($dateStart,$dateEnd);
        $qtyBill = $this->ajaxRepository->countBill($dateStart,$dateEnd);
        $qtyPaidBill = $this->ajaxRepository->countPaidBill($dateStart,$dateEnd);
        $qtyServingBill = $this->ajaxRepository->countServingBill($dateStart,$dateEnd);
        $data[] = array(
            'total' => $totalRevenue,
            'bill' => $qtyBill,
            'paid' => $qtyPaidBill,
            'serving' => $qtyServingBill
        );
        return response()->json($data);
    }

    public function getUnPaidImport($idSupplier)
    {
        $imports = ImportCoupon::where('status','0')->where('id_supplier',$idSupplier)->with('supplier')->get();
        return response()->json($imports);
    }

    public function searchSupplier($search)
    {
        $results = Supplier::where('name','LIKE',"%{$search}%")->get();
        return response()->json($results);
    }

    public function getDishOrderTable($idBill)
    {
        $dishes = OrderDetailTable::where('id_bill',$idBill)->with('dish')->get();
        return response()->json($dishes);
    }

    public function getImportCouponToPaymentVc($dateStart,$dateEnd,$idSupplier)
    {
        $coupons = $this->ajaxRepository->getImportCouponToCreatePaymentVoucher($dateStart,$dateEnd,$idSupplier);
        $conclusion = $this->ajaxRepository->getConcludeImportCoupon($coupons);
        $data = [
            'coupons' => $coupons,
            'conclusion' => $conclusion
        ];
        return response()->json($data);
    }

    public function searchPaymentVoucher($code)
    {
        $results = PaymentVoucher::where('code','LIKE',"{$code}")->orWhere('pay_cash','LIKE',"%{$code}%")->with('detailPaymentVc.detailMaterial.unit')->get();
        return response()->json($results);
    }

    public function getProfit($dateStart,$dateEnd)
    {
        $revenue = $this->ajaxRepository->getRevenue($dateStart,$dateEnd);
        $expense = $this->ajaxRepository->getExpense($dateStart,$dateEnd);
        $profit = $revenue - $expense;
        $data = [
            'revenue' => number_format($revenue) . ' đ',
            'expense' => number_format($expense) . ' đ',
            'profit' => number_format($profit) . ' đ'
        ];
        return response()->json($data);
    }

    public function createCustomerChart($typeTime)
    {
        $time = $this->ajaxRepository->getDateTime($typeTime);
        $data = $this->ajaxRepository->getAllQtyCustomer($time);
        return response()->json($data);
    }

    public function getMaterialByIdCook($idCook)
    {
        $materialDetails = $this->ajaxRepository->getMaterialWarehouseCook($idCook);
        return response()->json($materialDetails);
    }
}
