<?php

namespace App\Http\Controllers;

use App\CookArea;
use App\Supplier;

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
        return response()->json($data, 200);
    }

    public function getObjectToExport($id)
    {
        if($id == 1){
            $cooks = CookArea::all();
            return response()->json($cooks, 200);
        }
        else if($id == 2){
            $suppliers = Supplier::all();
            return response()->json($suppliers, 200);
        }
        else if($id == 3){
            $data = array();
            $data = [
                'id' => 3,
                'name' => 'Hủy'
            ];
            return response()->json($data, 200);
        }
    }

    public function getMaterialWarehouseToDestroy($idType)
    {
        $materialWarehouse = WareHouse::where('id_type',$idType)
                                        ->with('detailMaterial','unit')
                                        ->get();
        return $materialWarehouse;
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

    public function getSearchMaterialDetail($name)
    {
        $materialDetails = MaterialDetail::where('name','LIKE',"%{$name}%")->get();
        if(is_null($materialDetails)){
            return response()->json([ "message" => "Record not found"], 404);
        }
        return response()->json($materialDetails,200);
    }

    public function getObjectToReport($idType)
    {
        if($idType == '1'){
            $data = array();
                $data = [
                    'idData' => 4,
                    'name' => 'Kho chính'
                ];
            return response()->json($data);
        }else if($idType == '2'){
            $cooks = CookArea::all();
            return response()->json($cooks);
        }
    }
    public function getDateTimeToReport($id)
    {
        if($id == '1'){
            $data = array();
            $data = [
                'dateStart' => $this->ajaxRepository->getDateNow() . ' 00:00:00' ,
                'dateEnd' => $this->ajaxRepository->getDateNow() . ' 23:59:59' ,
            ];
            return response()->json($data);
        }else if($id == '2'){
            $data = array();
            $data = [
                'dateStart' => $this->ajaxRepository->getDateNow(),
                'dateEnd' => $this->ajaxRepository->getWeek()
            ];
            return response()->json($data);
        }
        else if($id == '3'){
            $data = array();
            $data = [
                'dateStart' => $this->ajaxRepository->getDateNow(),
                'dateEnd' => $this->ajaxRepository->getMonth()
            ];
            return response()->json($data);
        }
        else if($id == '4'){
            $data = array();
            $data = [
                'dateStart' => $this->ajaxRepository->getDateNow(),
                'dateEnd' => $this->ajaxRepository->getYear()
            ];
            return response()->json($data);
        }
    }

    public function searchMaterialDestroy($name)
    {
        $material = WareHouse::with('detailMaterial','unit')
                            ->whereHas('detailMaterial', function ($query) use($name) {
                                $query->where('name','LIKE','%'. $name . '%');
                            })->get();
        return response()->json($material);
    }

    public function searchMaterialDestroyCook($id,$name)
    {
        $material = WarehouseCook::where('cook',$id)->with('detailMaterial','unit')
                                    ->whereHas('detailMaterial', function ($query) use($name) {
                                        $query->where('name','LIKE','%'. $name . '%');
                                    })->get();
        return response()->json($material);
    }
}
