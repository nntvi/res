<?php
namespace App\Repositories\AjaxRepository;

use App\Unit;
use App\Order;
use App\Method;
use App\CookArea;
use App\Supplier;
use App\GroupMenu;
use App\WareHouse;
use Carbon\Carbon;
use App\Permission;
use App\ImportCoupon;
use App\TypeMaterial;
use App\WarehouseCook;
use App\MaterialAction;
use App\PaymentVoucher;
use App\OrderDetailTable;
use App\ExportCouponDetail;
use App\ImportCouponDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Helper\IGetDateTime;
class AjaxRepository extends Controller implements IAjaxRepository{

    private $ajaxRepository;
    private $getDateTime;

    public function __construct(IGetDateTime $getDateTime)
    {
        $this->getDateTime = $getDateTime;
    }

    public function getDateTime($id)
    {
        $data = array();
        switch ($id) {
            case 0:
                $data = [
                    'dateStart' => $this->getDateTime->getNow()->format('Y-m-d') . ' 00:00:00' ,
                    'dateEnd' => $this->getDateTime->getNow()->format('Y-m-d') . ' 23:59:59' ,
                ];
                break;
            case 1:
                $data = [
                    'dateStart' => $this->getDateTime->getYesterday() . ' 00:00:00' ,
                    'dateEnd' => $this->getDateTime->getYesterday() . ' 23:59:59' ,
                ];
                break;
            case 2:
                $data = [
                    'dateStart' => $this->getDateTime->getStartOfWeek(),
                    'dateEnd' => $this->getDateTime->getEndOfWeek(),
                ];
                break;
            case 3:
                $data = [
                    'dateStart' => $this->getDateTime->getStartOfPreWeek(),
                    'dateEnd' => $date = $this->getDateTime->getEndOfPreWeek(),
                ];
                break;
            case 4:
                $data = [
                    'dateStart' => $this->getDateTime->getStartOfMonth(),
                    'dateEnd' => $this->getDateTime->getEndOfMonth(),
                ];
                break;
            case 5:
                $data = [
                    'dateStart' => $this->getDateTime->getStartOfPreMonth(),
                    'dateEnd' => $this->getDateTime->getEndOfPreMonth(),
                ];
                break;
            case 6:
                $data = [
                    'dateStart' => $this->getDateTime->getStartOfQuarter(),
                    'dateEnd' => $this->getDateTime->getEndOfQuarter(),
                ];
                break;
            case 7:
                $data = [
                    'dateStart' => $this->getDateTime->getStartOfPreQuarter(),
                    'dateEnd' => $this->getDateTime->getEndOfPreQuarter(),
                ];
                break;
            case 8:
                $data = [
                    'dateStart' => $this->getDateTime->getFirstOfYear()->format('Y-m-d'),
                    'dateEnd' => $this->getDateTime->getLastOfYear()->format('Y-m-d'),
                ];
                break;
            default:
        }
        return $data;
    }
    public function getAllCook()
    {
        $cooks = CookArea::get();
        return $cooks;
    }
    public function getUnit()
    {
        $units = Unit::orderBy('name')->get();
        return $units;
    }
    public function getMaterialBySupplier($idSupplier)
    {
        $materials = Supplier::where('id',$idSupplier)->with('typeMaterial.warehouse.detailMaterial.unit')->first();
        return $materials;
    }

    public function getMaterialWarehouseCook($idCook)
    {
        $materials = WarehouseCook::where('cook',$idCook)->with('detailMaterial','unit')->get();
        return $materials;
    }

    public function getIdMaterialByIdCook($materials)
    {
        $idMaterialArray = array();
        foreach ($materials as $key => $material) {
            if($material->detailMaterial->status == '1'){
                $idMaterialArray[] = $material->id_material_detail;
            }
        }
        return $idMaterialArray;
    }

    public function findMaterialInWarehouse($idMaterialArray)
    {
        $materialWarehouse = WareHouse::whereIn('id_material_detail',$idMaterialArray)->with('detailMaterial','unit')->get();
        return $materialWarehouse;
    }

    public function getTypeByIdSupplier($idSupplier)
    {
        $type = Supplier::where('id',$idSupplier)->first('id_type');
        return $type;
    }

    public function getMaterialInWarehouseByType($type)
    {
        $materials = WareHouse::where('id_type',$type)->with('detailMaterial','unit')->get();
        return $materials;
    }

    public function getTypeMaterial()
    {
        $types = TypeMaterial::all();
        return $types;
    }
    public function getAllWarehouseToDestroy()
    {
        $materials  = WareHouse::all();
        return $materials;
    }

    public function warehouseBetweenTime($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $warehouse = WareHouse::whereBetween('updated_at',[$dateStart . $s , $dateEnd . $e])->with('detailMaterial','typeMaterial','unit')
                                    ->orderBy('id_material_detail')->get();
        return $warehouse;
    }
    public function importBetween($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailImport = ImportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->groupBy('id_material_detail')->orderBy('id_material_detail')->get();
        return $detailImport;
    }

    public function exportBetween($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->groupBy('id_material_detail')->orderBy('id_material_detail')->get();
        return $detailExport;
    }

    public function searchMaterialDestroy($name)
    {
        $material = WareHouse::with('detailMaterial','unit')
                            ->whereHas('detailMaterial', function ($query) use($name) {
                                $query->where('name','LIKE','%'. $name . '%');
                            })->whereHas('detailMaterial', function ($query) {
                                $query->where('status','1');
                            })->get();
        return $material;
    }

    public function searchMaterialDestroyCook($id,$name){
        $material = WarehouseCook::where('cook',$id)->with('detailMaterial','unit')
                                    ->whereHas('detailMaterial', function ($query) use($name) {
                                        $query->where('name','LIKE','%'. $name . '%');
                                    })->whereHas('detailMaterial', function ($query) {
                                        $query->where('status','1');
                                    })->get();
        return $material;
    }

    public function getEquation()
    {
        $heSo = Method::where('status','1')->first();
        if($heSo == null){
            return (35/100);
        }else{
            if($heSo->result == null || $heSo->result == ""){
                return (35/100);
            }else{
                return $heSo->result;
            }
        }
    }

    public function getCapitalPriceByIdMaterial($idMaterial)
    {
        $arrayActions = MaterialAction::where('id_groupnvl',$idMaterial)->get();
        $data = array();
        $capitalPrice = 0;
        foreach ($arrayActions as $key => $action) {
            $capitalPrice += $action->qty * $action->price;
        }
        $salePrice = round(($capitalPrice / (float) $this->getEquation()));
        $data = [
            'capitalPrice' => $capitalPrice,
            'salePrice' => $salePrice
        ];
        return $data;
    }

    public function countBill($dateStart,$dateEnd)
    {
        $qtyBill = Order::selectRaw('count(status) as qtyBill')->whereBetween('created_at',[$dateStart,$dateEnd])->value('qtyBill');
        return $qtyBill;
    }
    public function countPaidBill($dateStart,$dateEnd)
    {
        $qtyPaidBill = Order::selectRaw('count(status) as qtyPaid')->where('status','0')->whereBetween('created_at',[$dateStart,$dateEnd])->value('qtyPaid');
        return $qtyPaidBill;
    }

    public function countServingBill($dateStart,$dateEnd)
    {
        $qtyServingBill = Order::selectRaw('count(status) as qtyServing')->where('status','1')->whereBetween('created_at',[$dateStart,$dateEnd])->value('qtyServing');
        return $qtyServingBill;
    }

    public function getImportCouponToCreatePaymentVoucher($dateStart,$dateEnd,$idSupplier)
    {
        $coupons = ImportCoupon::whereBetween('created_at',[$dateStart,$dateEnd])->where('id_supplier',$idSupplier)->with('detailImportCoupon')->get();
        return $coupons;
    }

    public function getConcludeImportCoupon($coupons)
    {
        $total = 0; $unPaid = 0; $paid = 0;
        foreach ($coupons as $key => $coupon) {
            $total += $coupon->total;
            $paid += $coupon->paid;
        }
        $temp = [
            'sumTotal' => $total,
            'paid' => $paid,
            'unPaid' => $total - $paid,
        ];
        return $temp;
    }

    public function getRevenue($dateStart,$dateEnd)
    {
        $revenue = Order::selectRaw('sum(total_price) as total')->whereBetween('created_at',[$dateStart,$dateEnd])->where('status','0')->value('total');
        return $revenue == null ? 0 : $revenue;
    }

    public function getCapitalPriceOfDish($dateStart,$dateEnd)
    {
        $dishOrders = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')->whereBetween('updated_at',[$dateStart,$dateEnd])
                                        ->whereIn('status',['1','2'])->groupBy('id_dish')->with('dish')->get();
        $capitalPrice = 0;
        foreach ($dishOrders as $key => $dishOrder) {
            $capitalPrice += ($dishOrder->sumQty) * ($dishOrder->dish->capital_price);
        }
        return $capitalPrice;
    }

    public function getTotalPayment($dateStart,$dateEnd)
    {
        $payCash = PaymentVoucher::selectRaw('sum(pay_cash) as total')->whereBetween('created_at',[$dateStart,$dateEnd])->value('total');
        return $payCash == null ? 0 : $payCash;
    }

    public function getExpense($dateStart,$dateEnd)
    {
        $capitalPrice = $this->getCapitalPriceOfDish($dateStart,$dateEnd);
        $payCash = $this->getTotalPayment($dateStart,$dateEnd);
        return $capitalPrice + $payCash;
    }

    public function getQtyCustomerByTime($timeStart,$timeEnd)
    {
        $qtyCustomers = Order::selectRaw('count(id) as qty')->whereBetween('created_at',[$timeStart,$timeEnd])->where('status','0')->value('qty');
        return $qtyCustomers;
    }

    public function createObjToPushQtyCustomer($timeStart,$timeEnd)
    {
        $obj = array(
            'timeStart' => $timeStart,
            'timeEnd' => $timeEnd,
            'value' => $this->getQtyCustomerByTime($timeStart,$timeEnd),
        );
        return $obj;
    }

    public function getAllQtyCustomer($time)
    {
        $data = array();
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 08:00:00',$time['dateEnd'] . ' 08:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 09:00:00',$time['dateEnd'] . ' 09:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 10:00:00',$time['dateEnd'] . ' 10:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 11:00:00',$time['dateEnd'] . ' 11:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 12:00:00',$time['dateEnd'] . ' 12:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 13:00:00',$time['dateEnd'] . ' 13:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 14:00:00',$time['dateEnd'] . ' 14:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 15:00:00',$time['dateEnd'] . ' 15:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 16:00:00',$time['dateEnd'] . ' 16:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 17:00:00',$time['dateEnd'] . ' 17:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 18:00:00',$time['dateEnd'] . ' 18:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 19:00:00',$time['dateEnd'] . ' 19:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 20:00:00',$time['dateEnd'] . ' 20:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 21:00:00',$time['dateEnd'] . ' 21:59:59'));
        array_push($data,$this->createObjToPushQtyCustomer($time['dateStart'] . ' 22:00:00',$time['dateEnd'] . ' 22:59:59'));
        return $data;
    }
}
