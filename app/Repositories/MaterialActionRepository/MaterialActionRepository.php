<?php
namespace App\Repositories\MaterialActionRepository;

use App\HistoryWhCook;
use App\Http\Controllers\Controller;
use App\Material;
use App\Unit;
use App\MaterialDetail;
use App\MaterialAction;
use App\SettingPrice;
use App\StartDay;
use App\TypeMaterial;
use App\WarehouseCook;
use Carbon\Carbon;

class MaterialActionRepository extends Controller implements IMaterialActionRepository{

    public function getAllMaterials()
    {
        $materials = Material::with('materialAction.materialDetail')->get();
        return $materials;
    }

    public function getMaterialById($id)
    {
        $material = Material::where('id',$id)->with('materialAction.materialDetail','materialAction.unit')->first();
        return $material;
    }

    public function getMaterialDetails($id)
    {
        $actions = MaterialAction::where('id_groupnvl',$id)->get('id_material_detail');
        $materialDetails = MaterialDetail::whereNotIn('id',$actions)->where('status','1')->orderBy('name','asc')->with('unit')->get();
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
        $materialAction = MaterialAction::where('id',$id)->with('materialDetail','unit','material')->get();
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

    public function getMaterialAction($id)
    {
        $ingredients = MaterialAction::where('id_groupnvl',$id)->with('materialDetail','unit')->get();
        return $ingredients;
    }
    public function viewStoreMaterialAction($id)
    {
        $material = $this->findMaterialById($id);
        $units = $this->getUnit();
        $materialDetails = $this->getMaterialDetails($id);
        $ingredients = $this->getMaterialAction($id);
        $typeMaterialDetails = TypeMaterial::get();
        return view('materialaction.store',compact('material','units','materialDetails','ingredients','typeMaterialDetails'));
    }

    public function getIdCookByIdMaterial($id_groupnvl)
    {
        $material = Material::where('id',$id_groupnvl)->with('groupMenu')->get();
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

    public function checkStartDay()
    {
        $dayNow = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $value = StartDay::where('date',$dayNow)->value('id');
        return $value;
    }

    public function addWarehouseCook($cook,$idMaterialDetail,$id_unit)
    {
        $rowCookWarehouse = new WarehouseCook();
        $rowCookWarehouse->cook = $cook;
        $rowCookWarehouse->id_material_detail = $idMaterialDetail;
        $rowCookWarehouse->qty = 0.00;
        $rowCookWarehouse->id_unit = $id_unit;
        $rowCookWarehouse->status = '0';
        $rowCookWarehouse->save();
    }

    public function addHistoryCook($cook,$idMaterialDetail,$id_unit)
    {
        $historyCook = new HistoryWhCook();
        $historyCook->id_cook = $cook;
        $historyCook->id_material_detail = $idMaterialDetail;
        $historyCook->first_qty = 0;
        $historyCook->last_qty = 0;
        $historyCook->id_unit = $id_unit;
        $historyCook->save();
    }
    public function checkHistoryCookandWarehouseCook($cook,$idMaterialDetail,$id_unit)
    {
        $checkStartDay = $this->checkStartDay();
        if($checkStartDay == null || $checkStartDay == ""){ // chưa khai ca
            $this->addWarehouseCook($cook,$idMaterialDetail,$id_unit);
        }else{
            $this->addWarehouseCook($cook,$idMaterialDetail,$id_unit);
            $this->addHistoryCook($cook,$idMaterialDetail,$id_unit);
        }
    }

    public function getUnitByMaterialDetail($idMaterialDetail)
    {
        $idUnit = MaterialDetail::where('id',$idMaterialDetail)->value('id_unit');
        return $idUnit;
    }

    public function getSameMaterial($arrayMaterial)
    {
        $temp = array();
        $n = count($arrayMaterial);
        for ($i=0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($arrayMaterial[$i] == $arrayMaterial[$j] && $j != $i) {
                    array_push($temp,$j);
                    $n--;
                }
            }
        }
        $temp = array_unique($temp);
        return $temp;
    }

    public function addOneByOneMaterialAction($request,$i)
    {
        $materialDetail = new MaterialAction();
        $materialDetail->id_groupnvl = $request->id_groupnvl;
        $cook = $this->getIdCookByIdMaterial($request->id_groupnvl);
        $materialDetail->id_material_detail = $request->id_material[$i];
        $materialDetail->id_dvt = $this->getUnitByMaterialDetail($request->id_material[$i]);
        $materialDetail->qty = $request->qty[$i];
        $tempPrice = SettingPrice::where('id_material_detail',$request->id_material[$i])->value('price');
        $materialDetail->price = $tempPrice;
        $materialDetail->save();
        if($this->checkMaterialDetailInWarehouseCook($this->checkWarehouse($cook),$materialDetail->id_material_detail)){
            $this->checkHistoryCookandWarehouseCook($cook,$materialDetail->id_material_detail,$materialDetail->id_dvt);
        }
    }

    public function checkUnique($count,$request)
    {
        $check = $this->getSameMaterial($request->id_material);
        if(!empty($check)){ // có bị trùng
            for ($i=0; $i < $count; $i++) {
                for ($j=0; $j < count($check); $j++) {
                    if($i != $check[$j]){
                        $this->addOneByOneMaterialAction($request,$i);
                    }
                }
            }
        }else{
            for ($i=0; $i < $count; $i++) {
                $this->addOneByOneMaterialAction($request,$i);
            }
        }
    }

    public function storeMaterialAction($request,$id)
    {

        $count = $this->countMaterialRequest($request);
        $this->checkUnique($count,$request);
        return redirect(route('material.index'))->withSuccess('Thiết lập công thức thành công');
    }

    public function showMoreDetailById($id)
    {
        $material = $this->getMaterialById($id);
        return view('materialaction.detail',compact('material'));
    }

    public function updateMaterialAction($request,$id)
    {
        MaterialAction::where('id',$id)->update(['qty' => $request->qty ]);
        $idGroupNVL = $this->findRowMaterialAction($id);
        return redirect(route('material_action.detail',['id' => $idGroupNVL->id_groupnvl]))->with('info','Cập nhật công thức thành công');
    }

    public function deleteMaterialAction($id)
    {
        $mat_detail = $this->findRowMaterialAction($id);
        $mat_detail->delete();
        return redirect(route('material_action.detail',['id' => $mat_detail->id_groupnvl]))->withSuccess('Xóa NVL thành công');
    }
}
