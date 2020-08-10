<?php
namespace App\Repositories\WarehouseCookRepository;

use App\CookArea;
use App\HistoryWhCook;
use App\Http\Controllers\Controller;
use App\WarehouseCook;

class WarehouseCookRepository extends Controller implements IWarehouseCookRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_KHO_BEP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_KHO_BEP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getCookActive()
    {
        $cooks = CookArea::get();
        return $cooks;
    }
    public function getMaterialFromCook()
    {
        $cookWarehouse = CookArea::with('groupMenu.material.materialAction.materialDetail')->where('status','1')->get();
        return $cookWarehouse;
    }
    public function addMaterial($data,$cookwarehouse)
    {
        foreach ($data as $key => $value) {
            $rowCookWarehouse = new WarehouseCook();
            $rowCookWarehouse->cook = $cookwarehouse->id;
            $rowCookWarehouse->id_material_detail = $value;
            $rowCookWarehouse->qty = 0.00;
            $rowCookWarehouse->id_unit = 0;
            $rowCookWarehouse->save();
        }
    }
    public function createWarehouseCook()
    {
        $cookWarehouse = $this->getMaterialFromCook();
        $data = array();
        foreach ($cookWarehouse as $cookwarehouse) {
            foreach ($cookwarehouse->groupMenu as $groupmenu) {
                foreach ($groupmenu->material as $material) {
                    foreach ($material->materialAction as $value) {
                        $data[] = $value->id_material_detail;
                    }
                }
            }
            $data = array_unique($data);
            $this->addMaterial($data,$cookwarehouse);
            unset($data);
        }
    }

    public function getCookWarehouse()
    {
        $cookWarehouse = CookArea::with('warehouseCook.detailMaterial','warehouseCook.unit')->where('status','1')->get();
        return $cookWarehouse;
    }

    public function showWarehouseCook()
    {
        $cookWarehouse = $this->getCookWarehouse();
        //dd($cookWarehouse);
        $cooks = $this->getCookActive();
        return view('warehousecook.index',compact('cookWarehouse','cooks'));
    }

    public function resetWarehouseCook()
    {
        WarehouseCook::truncate();
        $this->createWarehouseCook();
        return $this->showWarehouseCook();
    }

    public function getListQtyFirstPeriod($dateStart,$dateEnd,$cook)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $fisrtQtyList = HistoryWhCook::selectRaw('id_material_detail, sum(first_qty) as qty')->whereBetween('created_at',[$dateStart . $s ,$dateEnd . $e])
                                ->where('id_cook',$cook)->groupBy('id_material_detail')->get();
        return $fisrtQtyList;
    }
    public function getQtyFirstPeriodById($idMaterialDetail,$dateStart,$dateEnd,$cook)
    {
        $list = $this->getListQtyFirstPeriod($dateStart,$dateEnd,$cook);
        foreach ($list as $key => $value) {
            if($value->id_material_detail == $idMaterialDetail){
                return $value->qty;
                break;
            }
        }
    }
    public function getListQtyLastPeriod($dateStart,$dateEnd,$cook)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $lastQtyList = HistoryWhCook::selectRaw('id_material_detail, sum(last_qty) as qty')->whereBetween('updated_at',[$dateStart . $s ,$dateEnd . $e])
                                ->where('id_cook',$cook)->groupBy('id_material_detail')->get();
        return $lastQtyList;
    }
    public function getQtyLastPeriodById($idMaterialDetail,$dateStart,$dateEnd,$cook)
    {
        $list = $this->getListQtyLastPeriod($dateStart,$dateEnd,$cook);
        foreach ($list as $key => $value) {
            if($value->id_material_detail == $idMaterialDetail){
                return $value->qty;
                break;
            }
        }
    }

    public function getHistoryWhCook($dateStart,$dateEnd,$cook)
    {
        $histories = HistoryWhCook::selectRaw('id_material_detail')->whereBetween('created_at',[$dateStart,$dateEnd])
                                ->where('id_cook',$cook)->groupBy('id_material_detail')->with('detailMaterial.unit','detailMaterial.typeMaterial')->get();
        return $histories;
    }

    public function createArrayToReport($dateStart,$dateEnd,$cook)
    {
        $histories = $this->getHistoryWhCook($dateStart,$dateEnd,$cook);
        $data = array();
        $temp = array();
        foreach ($histories as $key => $history) {
            $temp = [
                'stt' => $key + 1,
                'name_detail_material' => $history->detailMaterial->status == '1' ? $history->detailMaterial->name : $history->detailMaterial->name . ' (ko còn sử dụng)',
                'name_type_material' => $history->detailMaterial->typeMaterial->name,
                'name_unit' => $history->detailMaterial->unit->name,
                'tondauky' => $this->getQtyFirstPeriodById($history->id_material_detail,$dateStart,$dateEnd,$cook),
                'toncuoiky' => $this->getQtyLastPeriodById($history->id_material_detail,$dateStart,$dateEnd,$cook),
                'dasudung' => round(($this->getQtyFirstPeriodById($history->id_material_detail,$dateStart,$dateEnd,$cook)
                - $this->getQtyLastPeriodById($history->id_material_detail,$dateStart,$dateEnd,$cook)),2) ,
            ];
            array_push($data,$temp);
            unset($temp);
        }
        return $data;
    }

    public function reportWarehouseCook($request)
    {
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $cook = $request->cook;
        $cookFind = CookArea::where('id',$cook)->first();
        $cookDiffs = CookArea::whereNotIn('id',[$cook])->get();
        $result = $this->createArrayToReport($dateStart,$dateEnd,$cook);
        return view('warehousecook.report',compact('cookDiffs','cookFind','dateStart','dateEnd','result'));
    }

}



