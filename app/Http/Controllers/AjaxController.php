<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\GroupMenu;
use App\ImportCoupon;
use App\Supplier;
use App\Order;
use App\MaterialDetail;
use App\Repositories\AjaxRepository\IAjaxRepository;
use App\TypeMaterial;
use App\WareHouse;
use App\WarehouseCook;
use Carbon\Carbon;

use Illuminate\Http\Request;

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
    public function getMaterialToExportSupplier($idObjectSupplier)
    {
        $type = Supplier::where('id',$idObjectSupplier)->value('id_type');
        $materialWarehouse = $this->ajaxRepository->getMaterialInWarehouseByType($type);
        return response()->json($materialWarehouse);
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
                    'dateStart' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d') . ' 00:00:00' ,
                    'dateEnd' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d') . ' 23:59:59' ,
                ];
                break;
            case 1:
                $data = [
                    'dateStart' => Carbon::yesterday('Asia/Ho_Chi_Minh')->format('Y-m-d') . ' 00:00:00' ,
                    'dateEnd' => Carbon::yesterday('Asia/Ho_Chi_Minh')->format('Y-m-d') . ' 23:59:59' ,
                ];
                break;
            case 2:
                $data = [
                    'dateStart' => $date = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->format('Y-m-d'),
                    'dateEnd' => $date = Carbon::now('Asia/Ho_Chi_Minh')->endOfWeek()->format('Y-m-d'),
                ];
                break;
            case 3:
                $data = [
                    'dateStart' => Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->startOfWeek()->format('Y-m-d'),
                    'dateEnd' => Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->endOfWeek()->format('Y-m-d'),
                ];
                break;
            case 4:
                $data = [
                    'dateStart' => Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->format('Y-m-d'),
                    'dateEnd' => Carbon::now()->endOfMonth()->format('Y-m-d'),
                ];
                break;
            case 5:
                $data = [
                    'dateStart' => Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->format('Y-m-d'),
                    'dateEnd' => Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->format('Y-m-d'),
                ];
                break;
            case 6:
                $data = [
                    'dateStart' => Carbon::now('Asia/Ho_Chi_Minh')->firstOfQuarter()->format('Y-m-d'),
                    'dateEnd' => Carbon::now('Asia/Ho_Chi_Minh')->lastOfQuarter()->format('Y-m-d'),
                ];
                break;
            case 7:
                $data = [
                    'dateStart' => Carbon::now('Asia/Ho_Chi_Minh')->subQuarter()->firstOfQuarter()->format('Y-m-d'),
                    'dateEnd' => Carbon::now('Asia/Ho_Chi_Minh')->subQuarter()->lastOfQuarter()->format('Y-m-d'),
                ];
                break;
            case 8:
                $data = [
                    'dateStart' => Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear()->format('Y-m-d'),
                    'dateEnd' => Carbon::now('Asia/Ho_Chi_Minh')->lastOfYear()->format('Y-m-d'),
                ];
                break;
            default:
        }
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
        $imports = ImportCoupon::where('status','0')
                                ->where('id_supplier',$idSupplier)->with('supplier')->get();
        return response()->json($imports);
    }
}
