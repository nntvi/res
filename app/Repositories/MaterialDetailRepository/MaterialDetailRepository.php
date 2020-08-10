<?php
namespace App\Repositories\MaterialDetailRepository;

use App\Http\Controllers\Controller;
use App\SettingPrice;
use App\Repositories\MaterialDetailRepository\IMaterialDetailRepository;
use App\MaterialAction;
use App\MaterialDetail;
use App\TypeMaterial;
use App\Unit;
use App\WareHouse;
use App\WarehouseCook;

class MaterialDetailRepository extends Controller implements IMaterialDetailRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_NGUYEN_VAT_LIEU"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "TAO_NGUYEN_VAT_LIEU"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_NGUYEN_VAT_LIEU"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleDelete($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XOA_NGUYEN_VAT_LIEU"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getTypeMaterial()
    {
        $types = TypeMaterial::all();
        return $types;
    }

    public function getUnit()
    {
        $units = Unit::orderBy('name')->get();
        return $units;
    }

    public function getPrice()
    {
        $price = SettingPrice::get();
        return $price;
    }

    public function getMaterialDetail()
    {
        $materialDetails = MaterialDetail::where('status','1')->orderBy('id','desc')->with('typeMaterial','unit')->get();
        return $materialDetails;
    }

    public function validatorName($req){
        $req->validate(
            ['name' => 'check_status_mat_detail'],
            ['name.check_status_mat_detail' => 'Tên NVL đã tồn tại trong hệ thống']
        );
    }

    public function addNVLToWarehouse($request,$idMaterialDetail)
    {
        $warehouse = new WareHouse();
        $warehouse->id_type = $request->idType;
        $warehouse->id_material_detail = $idMaterialDetail;
        $warehouse->qty = 0;
        $warehouse->id_unit = $request->idUnit;
        $warehouse->limit_stock = $request->limit;
        $warehouse->save();
    }

    public function addNVLToSettingPrice($idMaterialDetail)
    {
        $settingPrice = new SettingPrice();
        $settingPrice->id_material_detail = $idMaterialDetail;
        $settingPrice->sltontruoc = 0;
        $settingPrice->giatontruoc = 0;
        $settingPrice->slnhapsau = 0;
        $settingPrice->gianhapsau = 0;
        $settingPrice->price = 0;
        $settingPrice->sltra = 0;
        $settingPrice->giatra = 0;
        $settingPrice->save();
    }

    public function addMaterialDetail($request)
    {
        $materialDetail = new MaterialDetail();
        $materialDetail->name = $request->name;
        $materialDetail->id_type = $request->idType;
        $materialDetail->id_unit = $request->idUnit;
        $materialDetail->status = '1';
        $materialDetail->save();
        $this->addNVLToWarehouse($request,$materialDetail->id);
        $this->addNVLToSettingPrice($materialDetail->id);
        return redirect(route('material_detail.index'))->withSuccess('Thêm NVL thành công');
    }

    public function updateNameMaterialDetail($request,$id)
    {
        MaterialDetail::where('id',$id)->update(['name' => $request->name]);
        return redirect(route('material_detail.index'))->with('info','Cập nhật tên NVL thành công');
    }

    public function updateTypeMaterialDetail($request,$id)
    {
        MaterialDetail::where('id',$id)->update(['id_type' => $request->type]);
        Warehouse::where('id_material_detail',$id)->update(['id_type' => $request->type]);
        return redirect(route('material_detail.index'))->with('info','Cập nhật nhóm thực đơn NVL thành công');
    }

    public function deleteMaterialDetail($id)
    {
        $materialAction = MaterialAction::where('id_material_detail',$id)->delete();
        MaterialDetail::where('id',$id)->update(['status' => '0']);
        return redirect(route('material_detail.index'))->withSuccess('Xóa NVL thành công');
    }
}
