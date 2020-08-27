<?php
namespace App\Repositories\ExportCouponRepository;

use App\EndDay;
use App\CookArea;
use App\StartDay;
use App\Supplier;
use App\WareHouse;
use Carbon\Carbon;
use App\TypeExport;
use App\ExportCoupon;
use App\ImportCoupon;
use App\SettingPrice;
use App\HistoryWhCook;
use App\WarehouseCook;
use App\MaterialDetail;
use App\ExportCouponDetail;
use App\ExportCouponSupplier;
use App\ExportCouponSupplierDetail;
use App\Http\Controllers\Controller;
use App\Unit;

class ExportCouponRepository extends Controller implements IExportCouponRepository{
    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_PHIEU_XUAT"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleStore($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "TAO_PHIEU_XUAT"){
                $temp++;
            }
        }
        return $temp;
    }
    public function getTypeExport()
    {
        $types = TypeExport::all();
        return $types;
    }

    public function getExportCoupons()
    {
        $exportCoupons = ExportCoupon::with('typeExport','detailExportCoupon')->orderBy('created_at','desc')->get();
        return $exportCoupons;
    }

    public function getExportCouponSupplier()
    {
        $exSuppliers = ExportCouponSupplier::with('importCoupon.supplier','detailExportSupplier')->orderBy('created_at','desc')->get();
        return $exSuppliers;
    }
    public function getMaterialByIdCook($idCook)
    {
        $cooks = CookArea::with('groupMenu')->get();
        return $cooks;
    }

    public function getObjectExport($id)
    {
        $name = ExportCouponDetail::where('id_excoupon',$id)->value('name_object');
        return $name;
    }

    public function findDetailExportCouponByCode($id)
    {
        $exportCoupon = ExportCoupon::where('id',$id)->with('detailExportCoupon.materialDetail','typeExport')->first();
        return $exportCoupon;
    }

    public function getDetailExport($id)
    {
        $exportCoupon = $this->findDetailExportCouponByCode($id);
        $objectExport = $this->getObjectExport($id);
        return view('exportcoupon.detail',compact('exportCoupon','objectExport'));
    }

    public function getDetailExportSupplier($id)
    {
        $exSupplierDt = ExportCouponSupplier::where('id',$id)->with('detailExportSupplier.materialDetail.unit','importCoupon.supplier')->first();
        return view('exportcoupon.detailsupplier',compact('exSupplierDt'));
    }

    public function validateExport($request)
    {
        $request->validate(['code' => 'unique:export_coupons,code'],['code.unique' => 'Mã phiếu xuất đã bị trùng']);
    }

    public function countMaterialExport($request)
    {
        $count = count($request->qty);
        return $count;
    }

    public function checkStartDay()
    {
        $nowDay = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $value = StartDay::where('date',$nowDay)->value('date');
        return $value;
    }

    public function checkEndDay()
    {
        $nowDay = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $value = EndDay::where('date',$nowDay)->value('id');
        return $value;
    }

    public function checkTypeExport($request,$i)
    {
        if($request->id_kind == 1){ // kho xuất cho bếp
            $this->substractQtyWarehouse($request->idMaterial[$i],$request->qty[$i]); // trừ kho
            $this->plusQtyWarehouseCook($request->idMaterial[$i],$request->qty[$i],$request->id_unit[$i],$request->type_object); // cộng bếp
        }else if($request->id_kind == 2 || $request->id_kind == 3){
            $this->substractQtyWarehouse($request->idMaterial[$i],$request->qty[$i]); // hủy kho
        }
    }

    public function getNameObject($idKind,$idObject)
    {
        if($idKind == '1' || $idKind == '4'){
            $name = CookArea::where('id',$idObject)->value('name');
        }else if($idKind == '2'){
            $name = Supplier::where('id',$idObject)->value('name');
        }else{
            $name = "Kho";
        }
        return $name;
    }

    public function plusQtyWarehouseCook($idMaterialDetail,$newQty,$idUnit,$idCook)
    {
        $oldQty = WarehouseCook::where('id_material_detail',$idMaterialDetail)->where('cook',$idCook)->first('qty');
        WarehouseCook::where('id_material_detail',$idMaterialDetail)->where('cook',$idCook)
                    ->update(['qty' => ($oldQty->qty + $newQty), 'id_unit' => $idUnit, 'status' => '1']);
    }

    public function substractQtyWarehouse($idMaterialDetail,$newQty)
    {
        $oldQty = WareHouse::where('id_material_detail',$idMaterialDetail)->value('qty');
        WareHouse::where('id_material_detail',$idMaterialDetail)->update(['qty' => $oldQty - $newQty]);
    }

    public function substractQtyWarehouseCook($idMaterialDetail,$idCook,$newQty)
    {
        $s = " 00:00:00"; $e = " 23:59:59";
        $checkStartDay = $this->checkStartDay();
        $checkEndDay = $this->checkEndDay();
        if($checkStartDay != null && $checkEndDay == null){ // đã khai ca và chưa chốt ca ngày đó
            $tempQty = HistoryWhCook::where('id_cook',$idCook)->where('id_material_detail',$idMaterialDetail)
                    ->whereBetween('created_at',[$checkStartDay . $s, $checkStartDay . $e])->value('first_qty');
            HistoryWhCook::where('id_cook',$idCook)->where('id_material_detail',$idMaterialDetail)
                    ->whereBetween('created_at',[$checkStartDay . $s, $checkStartDay . $e])->update(['first_qty' => $tempQty - $newQty]);
            $oldQty = WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetail)->value('qty');
            WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetail)->update(['qty' => $oldQty - $newQty]);
        }else{ // chưa khai ca
            $oldQty = WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetail)->value('qty');
            WarehouseCook::where('cook',$idCook)->where('id_material_detail',$idMaterialDetail)->update(['qty' => $oldQty - $newQty]);
        }
    }

    public function addExportCoupon($request)
    {
        $exportCoupon = new ExportCoupon();
        $exportCoupon->code = $request->code;
        $exportCoupon->id_type = $request->id_kind;
        $exportCoupon->note = $request->note;
        $exportCoupon->created_by = auth()->user()->name;
        $exportCoupon->save();
        return $exportCoupon->id;
    }

    public function addExportCouponSupplier($request)
    {
        $exSupplier = new ExportCouponSupplier();
        $exSupplier->code = $request->code;
        $exSupplier->note = $request->note;
        $exSupplier->id_coupon = ImportCoupon::where('code',$request->codeImport)->value('id');
        $exSupplier->created_by = auth()->user()->name;
        $exSupplier->save();
        return $exSupplier->id;
    }

    public function plusQtyHistoryCook($idCook,$idMaterialDetail,$qty)
    {
        $s = " 00:00:00"; $e = " 23:59:59";
        $checkStartDay = $this->checkStartDay();
        $checkEndDay = $this->checkEndDay();
        if($checkStartDay != null && $checkEndDay == null){ // đã khai ca và chưa chốt ca ngày đó
            $tempQty = HistoryWhCook::where('id_cook',$idCook)->where('id_material_detail',$idMaterialDetail)
                                    ->whereBetween('created_at',[$checkStartDay . $s, $checkStartDay . $e])->value('first_qty');
            HistoryWhCook::where('id_cook',$idCook)->where('id_material_detail',$idMaterialDetail)
                                    ->whereBetween('created_at',[$checkStartDay . $s, $checkStartDay . $e])->update(['first_qty' => $tempQty + $qty]);
        }
    }

    public function addDetailExportCoupon($request,$count,$idExportCoupon)
    {
        for ($i=0; $i < $count; $i++) {
            $detailExportCoupon = new ExportCouponDetail();
            $detailExportCoupon->id_excoupon = $idExportCoupon;
            $detailExportCoupon->code_export = $request->code;
            $detailExportCoupon->name_object = $this->getNameObject($request->id_kind,$request->type_object); // type_object là id bếp or NCC or Kho
            $detailExportCoupon->id_object = $request->id_kind == 3 ? 0 : (int) $request->type_object; // id ncc hoặc bếp
            $detailExportCoupon->id_material_detail = (int) $request->idMaterial[$i];
            $detailExportCoupon->qty = $request->qty[$i];
            $detailExportCoupon->id_unit = (int) $request->id_unit[$i];
            if($detailExportCoupon->id_object == 0 || $detailExportCoupon->id_object == 5){
                $this->substractQtyWarehouse($detailExportCoupon->id_material_detail,$detailExportCoupon->qty);
                $detailExportCoupon->save();
            }else{
                $this->plusQtyHistoryCook($request->type_object,$request->idMaterial[$i],$request->qty[$i]); // + vào lịch sử bếp
                $this->checkTypeExport($request,$i);
                $detailExportCoupon->save();
            }
        }
    }

    public function addDetailExportCouponSupplier($request,$count,$idExportCouponSupplier)
    {
        $temp = 0;
        for ($i=0; $i < $count; $i++) {
            $dtExSupplier = new ExportCouponSupplierDetail();
            $dtExSupplier->id_exsupplier = $idExportCouponSupplier;
            $dtExSupplier->code_import = $request->codeImport;
            $dtExSupplier->id_material_detail = $request->idMaterial[$i];
            $dtExSupplier->qty = $request->qty[$i];
            $dtExSupplier->price = ($request->price[$i] / $request->oldQty[$i]) * $request->qty[$i];
            $temp += $dtExSupplier->price;
            $this->substractQtyWarehouse($request->idMaterial[$i],$request->qty[$i]);
            $dtExSupplier->save();
        }
        ExportCouponSupplier::where('id',$idExportCouponSupplier)->update(['total' => $temp]);
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

    public function showViewExport($request)
    {
        $type = $request->optionsRadios;
        if($type == '1'){
            $random_string = 'XB';
            $code = $this->createCode($random_string);
            $cooks = CookArea::where('status','1')->get();
            return view('warehouseexport.exportcook',compact('cooks','code'));
        }
        else if($type == '2'){
            $random_string = 'XT';
            $code = $this->createCode($random_string);
            $suppliers = Supplier::all();
            return view('warehouseexport.exportsupplier',compact('suppliers','code'));
        }
    }

    public function exportMaterial($request)
    {
        $count = $this->countMaterialExport($request);
        $idExportCoupon = $this->addExportCoupon($request);
        $this->addDetailExportCoupon($request,$count,$idExportCoupon);
        return redirect(route('exportcoupon.index'))->withSuccess('Tạo phiếu xuất thành công');
    }

    public function calculatePrice($request,$i)
    {
        $sltontruoc = SettingPrice::where('id_material_detail',$request->idMaterial[$i])->value('sltontruoc');
        $giatontruoc = SettingPrice::where('id_material_detail',$request->idMaterial[$i])->value('giatontruoc');
        $slnhapsau = SettingPrice::where('id_material_detail',$request->idMaterial[$i])->value('slnhapsau');
        $gianhapsau = SettingPrice::where('id_material_detail',$request->idMaterial[$i])->value('gianhapsau');
        $giatra = $request->price[$i] / $request->oldQty[$i];
        $price = (($sltontruoc * $giatontruoc) + ($slnhapsau * $gianhapsau) - ($request->qty[$i] * $giatra)) / ($sltontruoc + $slnhapsau - $request->qty[$i]);
        SettingPrice::where('id_material_detail',$request->idMaterial[$i])->update(['price' => round($price)]);
    }

    public function updateSettingPrice($count,$request)
    {
        for ($i=0; $i < $count; $i++) {
            SettingPrice::where('id_material_detail',$request->idMaterial[$i])
                        ->update(array('sltra' => $request->qty[$i],'giatra' => $request->price[$i] / $request->oldQty[$i]));
            $this->calculatePrice($request,$i);
        }
    }

    public function exportSupplier($request)
    {
        $count = $this->countMaterialExport($request);
        $idExportCouponSupplier = $this->addExportCouponSupplier($request);
        $this->addDetailExportCouponSupplier($request,$count,$idExportCouponSupplier);
        $this->updateSettingPrice($count,$request);
        return redirect(route('exportcoupon.index'))->withSuccess('Tạo phiếu xuất thành công');
    }

    public function showIndex()
    {
        $exportCoupons = $this->getExportCoupons();
        $exSuppliers = $this->getExportCouponSupplier();
        return view('exportcoupon.index',compact('exportCoupons','exSuppliers'));
    }

    public function destroyWarehouse($request)
    {
        return $this->exportMaterial($request);
    }

    public function viewDestroyCook($id)
    {
        $cook = CookArea::where('id',$id)->first();
        $materials = WarehouseCook::where('cook',$id)->with('detailMaterial')->get();
        $code = $this->createCode("XHB");
        return view('warehouseexport.exportdestroycook',compact('cook','code','materials'));
    }
    public function addDetailExportCouponDestroyCook($request,$count,$idExportCoupon)
    {
        for ($i=0; $i < $count; $i++) {
            $detailExportCoupon = new ExportCouponDetail();
            $detailExportCoupon->id_excoupon = $idExportCoupon;
            $detailExportCoupon->code_export = $request->code;
            $detailExportCoupon->name_object = $this->getNameObject($request->id_kind,$request->type_object);
            $detailExportCoupon->id_object = $request->type_object;
            $detailExportCoupon->id_material_detail = $request->idMaterial[$i];
            $detailExportCoupon->qty = $request->qty[$i];
            $detailExportCoupon->id_unit = $request->id_unit[$i];
            $this->substractQtyWarehouseCook($request->idMaterial[$i],$request->type_object,$request->qty[$i]);
            $detailExportCoupon->save();
        }
    }

    public function destroyCook($request)
    {
        $count = $this->countMaterialExport($request);
        $idExportCoupon = $this->addExportCoupon($request);
        $this->addDetailExportCouponDestroyCook($request,$count,$idExportCoupon);
        return redirect(route('exportcoupon.index'))->withSuccess('Tạo phiếu hủy thành công');
    }

    public function printDetailExport($id)
    {
        $exportCoupon = ExportCoupon::where('id',$id)->with('typeExport', 'detailExportCoupon.unit','detailExportCoupon.materialDetail')->first();
        return view('exportcoupon.print',compact('exportCoupon'));
    }

    public function createTempMaterialToExport($arr,$idCook)
    {
        $temp = array();
        foreach ($arr as $key => $value) {
            $warehouse = Warehouse::where('id_material_detail',$value)->first();
            $t = [
                'idWh' => $warehouse->id,
                'idMaterial' => $value,
                'nameMaterial' => MaterialDetail::where('id',$value)->value('name'),
                'qtyWhC' => WarehouseCook::where('cook',$idCook)->where('id_material_detail',$value)->value('qty'),
                'qtyWh' => $warehouse->qty,
                'idUnit' => $warehouse->id_unit,
                'nameUnit' => Unit::where('id',$warehouse->id_unit)->value('name')
            ];
            array_push($temp,$t);
        }
        return $temp;
    }
}
