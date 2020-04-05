<?php
namespace App\Repositories\WarehouseCookRepository;

use App\CookArea;
use App\Http\Controllers\Controller;
use App\WarehouseCook;

class WarehouseCookRepository extends Controller implements IWarehouseCookRepository{

    public function getMaterialFromCook()
    {
        $cookWarehouse = CookArea::with('groupMenu.material.materialAction.materialDetail')->get();
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
        $cookWarehouse = CookArea::with('warehouseCook.detailMaterial','warehouseCook.unit')->get();
        return $cookWarehouse;
    }

    public function showWarehouseCook()
    {
        $cookWarehouse = $this->getCookWarehouse();
        //dd($cookWarehouse);
        return view('warehousecook.index',compact('cookWarehouse'));
    }

    public function resetWarehouseCook()
    {
        WarehouseCook::truncate();
        $this->createWarehouseCook();
        return $this->showWarehouseCook();
    }


}



