<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\GroupMenu;
use App\Helper\IGetDateTime;
use App\ImportCoupon;
use App\ImportCouponDetail;
use App\Supplier;
use App\Order;
use App\MaterialDetail;
use App\OrderDetailTable;
use App\Repositories\AjaxRepository\IAjaxRepository;
use App\TypeMaterial;
use App\WareHouse;
use App\WarehouseCook;
use Carbon\Carbon;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    private $ajaxRepository;
    private $getDateTime;

    public function __construct(IAjaxRepository $ajaxRepository,IGetDateTime $getDateTime)
    {
        $this->ajaxRepository = $ajaxRepository;
        $this->getDateTime = $getDateTime;
    }

    public function getMaterialBySupplier($idSupplier)
    {
        $materials = $this->ajaxRepository->getMaterialBySupplier($idSupplier);
        $units = $this->ajaxRepository->getUnit();
        $data = [
            'materials' => $materials,
            'units' => $units,
        ];
        return response()->json($data);
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
        $materials = ImportCouponDetail::where('code_import',$codeCoupon)
                                        ->with('materialDetail','unit')->get();
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
        return response()->json($data);
    }

    public function getDataChartBestSeller($timeStart,$timeEnd)
    {
        $dishes = OrderDetailTable::selectRaw('id_dish, sum(qty) as total')
                                    ->whereBetween('created_at',[$timeStart,$timeEnd])
                                    ->groupBy('id_dish')->with('dish')->get();
        $qtyDishes = array();
        foreach ($dishes as $key => $dish) {
            $obj = array(
                'nameDish' => $dish->dish->name,
                'qty' => $dish->total
            );
            array_push($qtyDishes,$obj);
        }
        return response()->json($qtyDishes);
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
        $imports = ImportCoupon::where('status','0')
                                ->where('id_supplier',$idSupplier)->with('supplier')->get();
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


}
