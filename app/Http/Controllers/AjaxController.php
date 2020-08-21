<?php

namespace App\Http\Controllers;

use App\Area;
use App\Plan;
use App\Order;
use App\Table;
use App\CookArea;
use App\Supplier;
use App\GroupMenu;
use App\WareHouse;
use Carbon\Carbon;
use App\OrderTable;
use App\ImportCoupon;
use App\TypeMaterial;
use App\WarehouseCook;

use App\MaterialDetail;
use App\PaymentVoucher;
use App\OrderDetailTable;
use App\ImportCouponDetail;
use Illuminate\Http\Request;
use App\Repositories\AjaxRepository\IAjaxRepository;
use App\ExportCouponSupplier;
use App\ExportCouponSupplierDetail;

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

    public function getMaterialByIdPlan($idPlan)
    {
        $materials = $this->ajaxRepository->getMaterialByIdPlan($idPlan);
        $idSupplier = Plan::where('id',$idPlan)->value('id_supplier');
        $data = array();
        foreach ($materials as $material) {
            $temp = [
                'idWh' => Warehouse::where('id_material_detail',$material->id_material_detail)->value('id'),
                'idMaterial' => $material->materialDetail->id,
                'name' => $material->materialDetail->name,
                'qtyWh' => Warehouse::where('id_material_detail',$material->id_material_detail)->value('qty'),
                'qtyPlan' => $material->qty,
                'idunit' => $material->materialDetail->unit->id,
                'unit' => $material->materialDetail->unit->name,
                'idSupplier' => $idSupplier
            ];
            array_push($data,$temp);
        }
        return response()->json($data);
    }

    public function get($id)
    {
        $wh = Warehouse::where('id_material_detail',$id)->first();
        return $wh;
    }
    public function getMaterialToExportCook($idObjectCook)
    {
        $data = array();
        $materailWarehouseCook = $this->ajaxRepository->getMaterialWarehouseCook($idObjectCook);
        $idMaterialArray = $this->ajaxRepository->getIdMaterialByIdCook($materailWarehouseCook);
        $materialWarehouse = $this->ajaxRepository->findMaterialInWarehouse($idMaterialArray);
        foreach ($materailWarehouseCook as $key => $item) {
            $temp = [
                'idWh' => Warehouse::where('id_material_detail',$item->id_material_detail)->value('id'),
                'idMatDet' => $item->id_material_detail,
                'qtyWh' => Warehouse::where('id_material_detail',$item->id_material_detail)->value('qty'),
                'qtyWhC' => $item->qty,
                'unit' => $item->unit->name,
                'idunit' => $item->unit->id,
                'name' => $item->detailMaterial->name,
            ];
            array_push($data,$temp);
        }
        return response()->json($data);
    }

    public function getImportCouponByIdSupplier($idSupplier)
    {
        $importCoupons = ImportCoupon::where('id_supplier',$idSupplier)->whereIn('status',['0','1'])->with('detailImportCoupon')->get();
        return response()->json($importCoupons);
    }

    public function getMaterialInWarehouseToExportSupplier($mat_wh,$idMaterialDetail)
    {
        foreach ($mat_wh as $key => $value) {
            if($value->id_material_detail == $idMaterialDetail){
                return $value->qty;
                break;
            }
        }
    }

    public function getQtyReturnByIdMaterialDetail($detailReturn,$idMaterialDetail)
    {
        $temp = 0;
        foreach ($detailReturn as $key => $value) {
            if($value->id_material_detail == $idMaterialDetail){
                $qty = $value->sumQty;
                $temp++;
            }
        }
        return $temp == 0 ? 0 : $qty;
    }
    public function getMaterialByImportCoupon($codeCoupon)
    {
        $idImportCoupon = ImportCoupon::where('code',$codeCoupon)->value('id'); // get Id phiếu nhập
        $materials = ImportCouponDetail::where('code_import',$codeCoupon)->with('materialDetail','unit')->get(); // tìm phiếu
        $idMaterial = ImportCouponDetail::where('code_import',$codeCoupon)->get('id_material_detail'); // tìm chi tiết của phiếu
        $mat_wh = $this->ajaxRepository->findMaterialInWarehouse($idMaterial);

        // tìm xem phiếu nhập đó có trả hàng bao h ko
        $idExportReturnSupplierDetail = ExportCouponSupplierDetail::where('code_import',$codeCoupon)->get('id'); // id phiếu trả
        if(count($idExportReturnSupplierDetail) == 0){ // phiếu nhập này chưa có mặt hàng nào trả lại
            $data = array();
            foreach ($materials as $key => $item) {
                $temp = [
                    'id' => $item->id,
                    'name' => $item->materialDetail->name,
                    'idmaterialdetail' => $item->id_material_detail,
                    'qty' => $item->qty,
                    'qtyReturn' => 0,
                    'price' => $item->price,
                    'idunit' => $item->unit->id,
                    'unit' => $item->unit->name,
                    'qtyWh' => $this->getMaterialInWarehouseToExportSupplier($mat_wh,$item->id_material_detail),
                ];
                array_push($data,$temp);
            }
            return response()->json($data);
        }else{ // đã có trả
            $detailReturn = ExportCouponSupplierDetail::selectRaw('id_material_detail, sum(qty) as sumQty')
                            ->where('code_import',$codeCoupon)->groupBy('id_material_detail')->get();
            $data = array();
            foreach ($materials as $key => $item) {
                $temp = [
                    'id' => $item->id,
                    'name' => $item->materialDetail->name,
                    'idmaterialdetail' => $item->id_material_detail,
                    'qty' => $item->qty,
                    'qtyReturn' => $this->getQtyReturnByIdMaterialDetail($detailReturn,$item->id_material_detail),
                    'price' => $item->price,
                    'idunit' => $item->unit->id,
                    'unit' => $item->unit->name,
                    'qtyWh' => $this->getMaterialInWarehouseToExportSupplier($mat_wh,$item->id_material_detail),
                ];
                array_push($data,$temp);
            }
            return response()->json($data);
        }
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

    public function getTableNotActiveByTableOrdered($tablesOfArea,$idArea)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $tableActives = OrderTable::whereBetween('updated_at',[$now . " 00:00:00",$now . " 23:59:59"])->where('status','1')->get('id_table');
        $tableNotActives = Table::where('id_area',$idArea)->where('status','1')->whereNotIn('id',$tableActives)->get();
        return $tableNotActives;
    }

    public function getDishOrderTable($idBill,$idTable)
    {
        $code = Order::where('id',$idBill)->value('code');
        $dishes = OrderDetailTable::where('id_bill',$idBill)->with('dish')->get(); // những món bàn đó order
        $area = Table::where('id',$idTable)->with('getArea')->first(); // lấy tên khu vực
        $tableOrder = OrderTable::where('id_order',$idBill)->with('table.getArea')->get(); // bàn đang đặt thuộc khu vực nào
        $tables = Area::where('id',$area->getArea->id)->with('containTable')->first(); // những bàn thuộc khu vực của bàn đang đặt
        $tableNotActives = $this->getTableNotActiveByTableOrdered($tables,$area->getArea->id); // bàn trống thuộc khu vực cần ghép
        $data = [
            'code' => $code,
            'dishes' => $dishes,
            'tableOrder' => $tableOrder,
            'nameArea' => $area->getArea->name,
            'tableNotActives' => $tableNotActives
        ];
        return response()->json($data);
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
        $results = PaymentVoucher::where('code','LIKE',"{$code}")->orWhere('pay_cash','LIKE',"%{$code}%")
                                    ->with('detailPaymentVc.detailMaterial.unit')->get();
        return response()->json($results);
    }

    public function getProfit($dateStart,$dateEnd)
    {
        $revenue = $this->ajaxRepository->getRevenue($dateStart,$dateEnd);
        $expense = $this->ajaxRepository->getExpense($dateStart,$dateEnd);
        $profit = $revenue - $expense;
        $capital = $this->ajaxRepository->getCapitalPriceOfDish($dateStart,$dateEnd);
        $payment = $this->ajaxRepository->getTotalPayment($dateStart,$dateEnd);
        $returnpay = $this->ajaxRepository->getPayReturnSupplier($dateStart,$dateEnd);
        $data = [
            'revenue' => number_format($revenue) . ' đ',
            'expense' => number_format($expense) . ' đ',
            'profit' => number_format($profit) . ' đ',
            'capital' => number_format($capital) . ' đ',
            'payment' => number_format($payment) . ' đ',
            'returnpay' => number_format($returnpay) . ' đ',
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

    public function searchDish($name)
    {
        $dishes = $this->ajaxRepository->getDishToSearch($name);
        return response()->json($dishes);
    }

    public function getAreaByIdTable($idTable)
    {
        $table = Table::where('id',$idTable)->with('getArea')->first();
        $tables = Area::where('id',$table->id_area)->with('containTable')->get();
        $data = [
            'nameArea' => $table->getArea->name,
            'tables' => $tables
        ];
        return response()->json($data);
    }

    public function reportDish($dateStart,$dateEnd,$idGroupmenu)
    {
        if ($idGroupmenu == 0) {
            $results = $this->ajaxRepository->getOrderByAllGroupMenu($dateStart,$dateEnd);
        } else {
            $results = $this->ajaxRepository->getOrderByIdGroupMenu($dateStart,$dateEnd,$idGroupmenu);
        }
        return response()->json($results);
    }

    public function getMaterialByIdType($idType,$idGroupmenu)
    {
        $materialDetails = $this->ajaxRepository->getMaterialByIdType($idType);
        $materialOfDish = $this->ajaxRepository->getMaterialOfDish($idGroupmenu);
        $data = $this->ajaxRepository->createArrayMethodForDish($materialDetails,$materialOfDish);
        $newArray = array();
        foreach ($data as $key => $value) {
            array_push($newArray,$value);
        }
        return response()->json($newArray);
    }

    public function getMaterialByIdMaterial($idMaterial)
    {
        $arrayMaterial = explode(',',$idMaterial);
        $data = array();
        for ($i=0; $i < count($arrayMaterial); $i++) {
           $result = MaterialDetail::where('id',$arrayMaterial[$i])->with('unit')->first();
           $temp = [
                'id' => $result->id,
                'name' => $result->name,
                'unit' => $result->unit->name,
           ];
           array_push($data,$temp);
        }
        return response()->json($data);
    }
}
