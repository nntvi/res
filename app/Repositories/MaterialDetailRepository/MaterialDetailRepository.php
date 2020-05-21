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
    public function showMaterialDetail()
    {
        $materialDetails = MaterialDetail::orderBy('id','desc')->with('typeMaterial','unit')->paginate(10);
        $types = $this->getTypeMaterial();
        $units = $this->getUnit();
        return view('materialdetail.index',compact('materialDetails','types','units'));
    }

    public function validatorRequestStore($req){
        $messeages = [
            'nameAdd.required' => 'Không để trống tên nvl',
            'nameAdd.min' => 'Tên nvl nhiều hơn 3 ký tự',
            'nameAdd.max' => 'Tên nvl giới hạn 30 ký tự',
            'nameAdd.unique' => 'Tên nvl đã tồn tại trong hệ thống'
        ];

        $req->validate(
            [
                'nameAdd' => 'required|min:3|max:30|unique:material_details,name',
            ],
            $messeages
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
        $materialDetail->name = $request->nameAdd;
        $materialDetail->id_type = $request->idType;
        $materialDetail->id_unit = $request->idUnit;
        $materialDetail->save();
        $this->addNVLToWarehouse($request,$materialDetail->id);
        $this->addNVLToSettingPrice($materialDetail->id);
        return redirect(route('material_detail.index'));
    }

    public function searchMaterialDetail($request)
    {
        $temp = $request->nameSearch;
        $materialDetails = MaterialDetail::where('name','LIKE',"%{$temp}%")->with('typeMaterial','unit')->get();
        $types = $this->getTypeMaterial();
        $units = $this->getUnit();
        return view('materialdetail.search',compact('materialDetails','types','units'));
    }

    public function validatorRequestUpdate($req){
        $req->validate(['nameUpdate' => 'unique:material_details,name'],
                        ['nameUpdate.unique' => 'Tên nvl đã tồn tại trong hệ thống']);
    }

    public function updateMaterialDetail($request,$id)
    {
        $materialDetail = MaterialDetail::find($id);
        $materialDetail->name = $request->name;
        $materialDetail->id_type = $request->type;
        $materialDetail->save();
        return redirect(route('material_detail.index'));
    }

    public function updateNameMaterialDetail($request,$id)
    {
        MaterialDetail::where('id',$id)->update(['name' => $request->nameUpdate]);
        return redirect(route('material_detail.index'));
    }

    public function updateTypeMaterialDetail($request,$id)
    {
        MaterialDetail::where('id',$id)->update(['id_type' => $request->type]);
        Warehouse::where('id_material_detail',$id)->update(['id_type' => $request->type]);
        return redirect(route('material_detail.index'));
    }
    public function deleteMaterialDetail($id)
    {
        $materialAction = MaterialAction::where('id_material_detail',$id)->delete();
        $materialDetail = MaterialDetail::find($id)->delete();
        WareHouse::where('id_material_detail',$id)->delete();
        WarehouseCook::where('id_material_detail',$id)->delete();
        return redirect(route('material_detail.index'));
    }
}
