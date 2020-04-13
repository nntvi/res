<?php
namespace App\Repositories\MaterialActionRepository;

use App\Http\Controllers\Controller;
use App\Material;
use App\Unit;
use App\MaterialDetail;
use App\MaterialAction;
use App\WarehouseCook;

class MaterialActionRepository extends Controller implements IMaterialActionRepository{

    public function getAllMaterials()
    {
        $materials = Material::with('materialAction.materialDetail')->get();
        return $materials;
    }

    public function getMaterialById($id)
    {
        $material = Material::where('id',$id)
                    ->with('materialAction.materialDetail','materialAction.unit')
                    ->get();
        return $material;
    }
    public function getMaterialDetails($id)
    {
        $actions = MaterialAction::where('id_groupnvl',$id)
                                ->get('id_material_detail');
        $materialDetails = MaterialDetail::whereNotIn('id',$actions)
                                            ->orderBy('name','asc')
                                            ->with('unit')
                                            ->get();
        return $materialDetails;
    }

    public function getUnit()
    {
        $units = Unit::orderBy('name','asc')->get();
        return $units;
    }

    public function findMaterialById($id)
    {
        $material = Material::where('id',$id)->first();
        return $material;
    }

    public function findMaterialActionById($id)
    {
        $materialAction = MaterialAction::where('id',$id)
                        ->with('materialDetail','unit','material')
                        ->get();
        return $materialAction;
    }

    public function findRowMaterialAction($id)
    {
        $mat_detail = MaterialAction::find($id);
        return $mat_detail;
    }

    public function countMaterialRequest($request)
    {
        $count = count($request->id_material);
        return $count;
    }

    public function showIndex()
    {
        $materials = $this->getAllMaterials();
        return view('materialaction.index',compact('materials'));
    }

    public function viewStoreMaterialAction($id)
    {
        $material = $this->findMaterialById($id);
        $units = $this->getUnit();
        $materialDetails = $this->getMaterialDetails($id);
        return view('materialaction.store',compact('material','units','materialDetails'));
    }

    public function getIdCookByIdMaterial($id_groupnvl)
    {
        $material = Material::where('id',$id_groupnvl)
                        ->with('groupMenu')->get();
        foreach ($material as $value) {
                $idCook = $value->groupMenu->id_cook;
        }
        return $idCook;
    }

    public function checkWarehouse($idCook)
    {
        $warehouseCook = WarehouseCook::where('cook',$idCook)->get();
        return $warehouseCook;
    }

    public function checkMaterialDetailInWarehouseCook($warehouseCook,$idMaterialDetail)
    {
        $a = 0;
        $b = 0;
        foreach ($warehouseCook as $key => $value) {
            $a++;
            if($value->id_material_detail != $idMaterialDetail){
                $b++;
            }
        }
        if($a == $b)
            return true;
        return false;
    }

    public function addWarehouseCook($cook,$idMaterialDetail,$id_unit)
    {
        $rowCookWarehouse = new WarehouseCook();
        $rowCookWarehouse->cook = $cook;
        $rowCookWarehouse->id_material_detail = $idMaterialDetail;
        $rowCookWarehouse->qty = 0.00;
        $rowCookWarehouse->id_unit = $id_unit;
        $rowCookWarehouse->save();
    }
    public function getUnitByMaterialDetail($idMaterialDetail)
    {
        $idUnit = MaterialDetail::where('id',$idMaterialDetail)
                                    ->value('id_unit');
        return $idUnit;
    }

    public function addOneByOneMaterialAction($count,$request)
    {
        for ($i=0; $i < $count; $i++) {
            $materialDetail = new MaterialAction();
            $materialDetail->id_groupnvl = $request->id_groupnvl;
            $cook = $this->getIdCookByIdMaterial($request->id_groupnvl);
            $materialDetail->id_material_detail = $request->id_material[$i];
            $materialDetail->id_dvt = $this->getUnitByMaterialDetail($request->id_material[$i]);
            $materialDetail->qty = $request->qty[$i];
            $materialDetail->save();
            if($this->checkMaterialDetailInWarehouseCook($this->checkWarehouse($cook),$materialDetail->id_material_detail)){
                $this->addWarehouseCook($cook,$materialDetail->id_material_detail,$materialDetail->id_dvt);
            }
        }
    }

    public function storeMaterialAction($request,$id)
    {
        $count = $this->countMaterialRequest($request);
        $this->addOneByOneMaterialAction($count,$request);
        return redirect(route('material_action.index'));
    }

    public function showMoreDetailById($id)
    {
        $materials = $this->getMaterialById($id);
        return view('materialaction.detail',compact('materials'));
    }

    public function showViewUpdateMaterialAction($id)
    {
        $materialAction = $this->findMaterialActionById($id);
        $units = $this->getUnit();
        return view('materialaction.update',compact('materialAction','units'));
    }

    public function updateMaterialAction($request,$id)
    {
        $mat_detail = $this->findRowMaterialAction($id);
        $mat_detail->id_dvt = $request->id_dvt;
        $mat_detail->qty = $request->qty;
        $mat_detail->save();
        return redirect(route('material_action.detail',['id' => $mat_detail->id_groupnvl]));
    }

    public function deleteMaterialAction($id)
    {
        $mat_detail = $this->findRowMaterialAction($id);
        $id_groupnvl = $mat_detail->id_groupnvl;
        $mat_detail->delete();
        return redirect(route('material_action.detail',['id' => $id_groupnvl]));
    }
}
