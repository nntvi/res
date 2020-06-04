<?php
namespace App\Repositories\AjaxRepository;

use App\CookArea;
use App\Http\Controllers\Controller;
use App\TypeMaterial;
use App\Unit;
use App\WareHouse;
use App\WarehouseCook;
use App\Supplier;
use App\ImportCouponDetail;
use App\ExportCouponDetail;
use App\GroupMenu;
use App\ImportCoupon;
use App\MaterialAction;
use App\Method;
use App\Order;
use App\OrderDetailTable;
use App\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AjaxRepository extends Controller implements IAjaxRepository{

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
        $materials = Supplier::where('id',$idSupplier)
                            ->with('typeMaterial.warehouse.detailMaterial','typeMaterial.warehouse.unit')
                            ->get();
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
            $idMaterialArray[] = $material->id_material_detail;
        }
        return $idMaterialArray;
    }

    public function findMaterialInWarehouse($idMaterialArray)
    {
        $materialWarehouse = WareHouse::whereIn('id_material_detail',$idMaterialArray)
                                        ->with('detailMaterial','unit')->get();
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
        $warehouse = WareHouse::whereBetween('updated_at',[$dateStart . $s , $dateEnd . $e])
                                    ->with('detailMaterial','typeMaterial','unit')
                                    ->orderBy('id_material_detail')->get();
        return $warehouse;
    }
    public function importBetween($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailImport = ImportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->groupBy('id_material_detail')->orderBy('id_material_detail')->get();
        return $detailImport;
    }

    public function exportBetween($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->groupBy('id_material_detail')->orderBy('id_material_detail')->get();
        return $detailExport;
    }

    public function searchMaterialDestroy($name)
    {
        $material = WareHouse::with('detailMaterial','unit')
                            ->whereHas('detailMaterial', function ($query) use($name) {
                                $query->where('name','LIKE','%'. $name . '%');
                            })->get();
        return $material;
    }

    public function searchMaterialDestroyCook($id,$name){
        $material = WarehouseCook::where('cook',$id)->with('detailMaterial','unit')
                                    ->whereHas('detailMaterial', function ($query) use($name) {
                                        $query->where('name','LIKE','%'. $name . '%');
                                    })->get();
        return $material;
    }

    public function getEquation()
    {
        $heSo = Method::where('status','1')->first('result');
        if($heSo == null){
            return (35/100);
        }else{
            return $heSo;
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

    public function getRevenue($dateStart,$dateEnd)
    {
        $totalRevenue = Order::selectRaw('sum(total_price) as total')
                                        ->whereBetween('created_at',[$dateStart,$dateEnd])
                                        ->value('total');
        return $totalRevenue;
    }

    public function countBill($dateStart,$dateEnd)
    {
        $qtyBill = Order::selectRaw('count(status) as qtyBill')
                        ->whereBetween('created_at',[$dateStart,$dateEnd])
                        ->value('qtyBill');
        return $qtyBill;
    }
    public function countPaidBill($dateStart,$dateEnd)
    {
        $qtyPaidBill = Order::selectRaw('count(status) as qtyPaid')->where('status','0')
                                ->whereBetween('created_at',[$dateStart,$dateEnd])
                                ->value('qtyPaid');
        return $qtyPaidBill;
    }

    public function countServingBill($dateStart,$dateEnd)
    {
        $qtyServingBill = Order::selectRaw('count(status) as qtyServing')->where('status','1')
                            ->whereBetween('created_at',[$dateStart,$dateEnd])
                            ->value('qtyServing');
        return $qtyServingBill;
    }

    public function getImportCouponToCreatePaymentVoucher($dateStart,$dateEnd,$idSupplier)
    {
        $coupons = ImportCoupon::whereBetween('created_at',[$dateStart,$dateEnd])
                                ->where('id_supplier',$idSupplier)
                                ->with('detailImportCoupon')->get();
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
}
