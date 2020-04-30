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
use App\MaterialAction;
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
        $materials = WarehouseCook::where('cook',$idCook)
                        ->with('detailMaterial','unit')
                        ->get();
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
                                        ->with('detailMaterial','unit')
                                        ->get();
        return $materialWarehouse;
    }

    public function getTypeByIdSupplier($idSupplier)
    {
        $type = Supplier::where('id',$idSupplier)->first('id_type');
        return $type;
    }

    public function getMaterialInWarehouseByType($type)
    {
        $materials = WareHouse::where('id_type',$type)
                                ->with('detailMaterial','unit')->get();
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

    public function getDateNow()
    {
        $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        return $date;
    }

    public function getWeek()
    {
        $week = Carbon::now('Asia/Ho_Chi_Minh')->addWeek()->toDateString();
        return $week;
    }

    public function getMonth()
    {
        $month = Carbon::now('Asia/Ho_Chi_Minh')->addMonth()->toDateString();
        return $month;
    }

    public function getYear()
    {
        $year = Carbon::now('Asia/Ho_Chi_Minh')->addYear()->toDateString();
        return $year;
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
                                            ->groupBy('id_material_detail')
                                            ->orderBy('id_material_detail')->get();
        return $detailImport;
    }

    public function exportBetween($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->groupBy('id_material_detail')
                                            ->orderBy('id_material_detail')->get();
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

    public function getCapitalPriceByIdMaterial($idMaterial)
    {
        $arrayActions = MaterialAction::where('id_groupnvl',$idMaterial)->get();
        $data = array();
        $capitalPrice = 0;
        foreach ($arrayActions as $key => $action) {
            $capitalPrice += $action->qty * $action->price;
        }
        $salePrice = round($capitalPrice + ($capitalPrice * 35/100));
        $data = [
            'capitalPrice' => $capitalPrice,
            'salePrice' => $salePrice
        ];
        return $data;
    }
}
