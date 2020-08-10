<?php
namespace App\Repositories\ImportCouponRepository;

use App\Plan;
use App\Unit;
use App\Supplier;
use App\WareHouse;
use Carbon\Carbon;
use App\ImportCoupon;
use App\SettingPrice;
use App\TypeMaterial;
use App\WarehouseCook;
use App\MaterialAction;
use App\MaterialDetail;
use App\ImportCouponDetail;
use App\Http\Controllers\Controller;

class ImportCouponRepository extends Controller implements IImportCouponRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_PHIEU_NHAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "TAO_PHIEU_NHAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_PHIEU_NHAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleDelete($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XOA_PHIEU_NHAP"){
                $temp++;
            }
        }
        return $temp;
    }

    public function getSuppliers()
    {
        $suppliers = Supplier::where('status','1')->get();
        return $suppliers;
    }

    public function getMaterialDetail()
    {
        $material_details = MaterialDetail::orderBy('name')->get();
        return $material_details;
    }

    public function getUnit()
    {
        $units = Unit::orderBy('name')->get();
        return $units;
    }

    public function getTypeMaterial()
    {
        $types = TypeMaterial::orderBy('name')->get();
        return $types;
    }

    public function validateCreatImportCoupon($request)
    {
        $request->validate(['code' => 'unique:import_coupons,code'],['code.unique' => "Mã phiếu nhập bị trùng"]);
    }
    public function showIndex()
    {
        $listImports = ImportCoupon::orderBy('created_at','desc')->with('supplier','detailImportCoupon')->get();
        return view('importcoupon.index',compact('listImports'));
    }

    public function generate_string($input,$strength,$random_string) {
        $input_length = strlen($input);
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

    public function createCode($random_string)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $code = $this->generate_string($permitted_chars,5,$random_string);
        return $code;
    }

    public function showViewImport()
    {
        $suppliers = $this->getSuppliers();
        $units = $this->getUnit();
        $types = $this->getTypeMaterial();
        $material_details = $this->getMaterialDetail();
        $code = $this->createCode("NH");
        return view('importcoupon.import',compact('suppliers','units','material_details','types','code'));
    }

    public function getToday()
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        return $today;
    }

    public function showViewImportPlan()
    {
        $code = $this->createCode("NKH");
        $today = $this->getToday();
        $plans = Plan::where('status','0')->where('date_create','>',$today)->with('supplier')->get();
        return view('importcoupon.impplan',compact('code','plans'));
    }
    public function countMaterialImport($request)
    {
        $count = count($request->id);
        return $count;
    }

    public function createImportCouponDetail($request,$i,$idImportCoupon)
    {
        $importcouponDetail = new ImportCouponDetail();
        $importcouponDetail->id_imcoupon = $idImportCoupon;
        $importcouponDetail->code_import = $request->code;
        $importcouponDetail->id_material_detail = $request->idMaterial[$i];
        $importcouponDetail->qty = $request->qty[$i];
        $importcouponDetail->id_unit = $request->id_unit[$i];
        $importcouponDetail->price = $request->price[$i];
        $importcouponDetail->save();
        return $importcouponDetail->price;
    }

    public function findDetailImportCouponByCode($code)
    {
        $detailImports = ImportCouponDetail::where('code_import',$code)->with('materialDetail','unit')->get();
        return $detailImports;
    }

    public function getTotalDetailImportCoupon($detailImports)
    {
        $total = 0;
        foreach ($detailImports as $key => $detail) {
            $total += $detail->price;
        }
        return $total;
    }
    public function createImportCoupon($request)
    {
        $importCoupon = new ImportCoupon();
        $importCoupon->code = $request->code;
        $importCoupon->id_supplier = $request->idSupplier;
        $importCoupon->total = 0;
        $importCoupon->paid = 0;
        $importCoupon->status = '0'; // chưa thanh toán
        $importCoupon->note = $request->note;
        $importCoupon->created_by = auth()->user()->name;
        $importCoupon->save();
        return $importCoupon->id;
    }

    public function getOldQty($i,$request)
    {
        $oldQty = WareHouse::where('id',$request->id[$i])->value('qty');
        return $oldQty;
    }
    public function calculatePrice($sltontruoc,$giatontruoc,$slnhapsau,$gianhapsau)
    {
        $price = round(($gianhapsau * $slnhapsau + $giatontruoc * $sltontruoc) / ($slnhapsau + $sltontruoc));
        return $price;
    }

    public function updatePriceInMaterialAction($idMaterialDetail,$price)
    {
        MaterialAction::where('id_material_detail',$idMaterialDetail)->update(['price' => $price]);
    }
    public function settingPrice($request,$i,$oldQty)
    {
        $id_material_detail = Warehouse::where('id',$request->id[$i])->value('id_material_detail');
        $settingPrice = SettingPrice::where('id_material_detail',$id_material_detail)->first();
        // nhập lần đầu
        if($settingPrice->sltontruoc == 0 && $settingPrice->giatontruoc == 0 && $settingPrice->slnhapsau == 0 && $settingPrice->gianhapsau == 0){
            $settingPrice->slnhapsau = $request->qty[$i];
            $settingPrice->gianhapsau = $request->price[$i] / $request->qty[$i];
            $settingPrice->price = $this->calculatePrice($settingPrice->sltontruoc,$settingPrice->giatontruoc,$settingPrice->slnhapsau,$settingPrice->gianhapsau);
            $settingPrice->save();
            $this->updatePriceInMaterialAction($id_material_detail,$settingPrice->price);
        }
        else {
            $settingPrice->sltontruoc = $oldQty;
            $settingPrice->giatontruoc = $settingPrice->gianhapsau;
            $settingPrice->slnhapsau = $request->qty[$i];
            $settingPrice->gianhapsau = $request->price[$i] / $request->qty[$i] ;
            $settingPrice->price = $this->calculatePrice($settingPrice->sltontruoc,$settingPrice->giatontruoc,$settingPrice->slnhapsau,$settingPrice->gianhapsau);
            $settingPrice->save();
            $this->updatePriceInMaterialAction($id_material_detail,$settingPrice->price);
        }
    }
    public function import($request)
    {
        $count = $this->countMaterialImport($request);
        $idImportCoupon = $this->createImportCoupon($request);
        $total = 0;
        for ($i=0; $i < $count; $i++) {
            $oldQty = $this->getOldQty($i,$request);
            $material = WareHouse::where('id',$request->id[$i])->update(['qty' => $oldQty + $request->qty[$i],'id_unit' => $request->id_unit[$i]]);
            $this->settingPrice($request,$i,$oldQty);
            $total += $this->createImportCouponDetail($request,$i,$idImportCoupon);
        }
        ImportCoupon::where('id',$idImportCoupon)->update(['total' => $total]);
        return redirect(route('importcoupon.index'))->withSuccess('Tạo phiếu nhập kho thành công');
    }

    public function findDetailImportCouponByIdImport($id)
    {
        $detailImport = ImportCoupon::where('id',$id)->with('detailImportCoupon.materialDetail','detailImportCoupon.unit','supplier')->first();
        return $detailImport;
    }

    public function getDetailImportCouponById($id)
    {
        $importCoupon = $this->findDetailImportCouponByIdImport($id);
        return view('importcoupon.detail',compact('importCoupon'));
    }

    public function updateDetailImportCoupon($request,$id)
    {
        $detailImport = ImportCouponDetail::where('id',$id)->update(['price' => $request->price]);
        $code = ImportCouponDetail::where('id',$id)->first('code_import');
        $allDetailByCode = $this->findDetailImportCouponByCode($code->code_import);
        $sum = $this->getTotalDetailImportCoupon($allDetailByCode);
        $import = ImportCoupon::where('code',$code->code_import)->update(['total' => $sum]);
        $idImport = ImportCoupon::where('code',$code->code_import)->first('id');
        return redirect(route('importcoupon.index'))->with('info','Cập nhật thành công');
    }

    public function findImportCouponByCode($code)
    {
        $import = ImportCoupon::where('code',$code)->with('supplier')->first();
        return $import;
    }

    public function printDetailByCode($id)
    {
        $importCoupon = $this->findDetailImportCouponByIdImport($id);
        return view('importcoupon.print',compact('importCoupon'));
    }
}
