<?php
namespace App\Repositories\ExportCouponRepository;

use App\CookArea;
use App\ExportCoupon;
use App\ExportCouponDetail;
use App\Http\Controllers\Controller;
use App\SettingPrice;
use App\Supplier;
use App\TypeExport;
use App\WareHouse;
use App\WarehouseCook;

class ExportCouponRepository extends Controller implements IExportCouponRepository{
    public function getTypeExport()
    {
        $types = TypeExport::all();
        return $types;
    }

    public function getExportCoupons()
    {
        $exportCoupons = ExportCoupon::with('typeExport','detailExportCoupon.cook','detailExportCoupon.supplier')->get();
        return $exportCoupons;
    }

    public function getMaterialByIdCook($idCook)
    {
        $cooks = CookArea::with('groupMenu')->get();
        return $cooks;
    }

    public function getCodeById($id)
    {
        $code = ExportCoupon::where('id',$id)->first('code');
        return $code;
    }

    public function getDetailExport($id)
    {
        $code = $this->getCodeById($id);
        $detailExportCoupon = $this->findDetailExportCouponByCode($code->code);
        return view('exportcoupon.detail',compact('detailExportCoupon'));
    }

    public function findDetailExportCouponByCode($code)
    {
        $detailExportCoupon = ExportCoupon::where('code',$code)
                                                ->with('detailExportCoupon.materialDetail','detailExportCoupon.unit')
                                                ->get();
        return $detailExportCoupon;
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

    public function addExportCoupon($request)
    {
        $exportCoupon = new ExportCoupon();
        $exportCoupon->code = $request->code;
        $exportCoupon->id_type = $request->id_kind;
        $exportCoupon->note = $request->note;
        $exportCoupon->save();
    }

    public function checkTypeExport($type,$request,$i)
    {
        if($type == 1){
            $this->substractQtyWarehouse($request->idMaterial[$i],$request->qty[$i]);
            $this->plusQtyWarehouseCook($request->idMaterial[$i],$request->qty[$i],$request->id_unit[$i]);
        }else if($type == 2 || $type == 3){
            $this->substractQtyWarehouse($request->idMaterial[$i],$request->qty[$i]);
        }
    }

    public function addDetailExportCoupon($request,$count)
    {
        for ($i=0; $i < $count; $i++) {
            $detailExportCoupon = new ExportCouponDetail();
            $detailExportCoupon->code_export = $request->code;
            $detailExportCoupon->id_object = $request->type_object;
            $detailExportCoupon->id_material_detail = $request->idMaterial[$i];
            $detailExportCoupon->qty = $request->qty[$i];
            $detailExportCoupon->id_unit = $request->id_unit[$i];
            $this->checkTypeExport($request->id_kind,$request,$i);
            $detailExportCoupon->save();
        }
    }

    public function plusQtyWarehouseCook($idMaterialDetail,$newQty,$idUnit)
    {
        $oldQty = WarehouseCook::where('id_material_detail',$idMaterialDetail)->first('qty');
        WarehouseCook::where('id_material_detail',$idMaterialDetail)
                        ->update(['qty' => $oldQty->qty + $newQty,
                                    'id_unit' => $idUnit,
                                    'status' => '1'
                                ]);
    }

    public function substractQtyWarehouse($idMaterialDetail,$newQty)
    {
        $oldQty = WareHouse::where('id_material_detail',$idMaterialDetail)->value('qty');
        WareHouse::where('id_material_detail',$idMaterialDetail)
                    ->update(['qty' => $oldQty - $newQty]);
    }

    public function substractQtyWarehouseCook($idMaterialDetail,$idCook,$newQty)
    {
        $oldQty = WarehouseCook::where('cook',$idCook)
                                ->where('id_material_detail',$idMaterialDetail)
                                ->value('qty');
        WarehouseCook::where('cook',$idCook)
                        ->where('id_material_detail',$idMaterialDetail)
                        ->update(['qty' => $oldQty - $newQty]);
    }
    public function showViewExport($request)
    {
        $type = $request->optionsRadios;
        if($type == '1'){
            $cooks = CookArea::where('status','1')->get();
            return view('warehouseexport.exportcook',compact('cooks'));
        }
        else if($type == '2'){
            $suppliers = Supplier::all();
            return view('warehouseexport.exportsupplier',compact('suppliers'));
        }
        else{
            return view('warehouseexport.exportdestroy');
        }
    }

    public function exportMaterial($request)
    {
        $count = $this->countMaterialExport($request);
        $this->addExportCoupon($request);
        $this->addDetailExportCoupon($request,$count);
        return redirect(route('exportcoupon.index'));
    }

    public function calculatePrice($request,$i)
    {
        $sltontruoc = SettingPrice::where('id_material_detail',$request->idMaterial[$i])->value('sltontruoc');
        $giatontruoc = SettingPrice::where('id_material_detail',$request->idMaterial[$i])->value('giatontruoc');
        $slnhapsau = SettingPrice::where('id_material_detail',$request->idMaterial[$i])->value('slnhapsau');
        $gianhapsau = SettingPrice::where('id_material_detail',$request->idMaterial[$i])->value('gianhapsau');
        $giatra = $request->price[$i] / $request->oldQty[$i];
        //dd($giatra);
        $price = (($sltontruoc * $giatontruoc) + ($slnhapsau * $gianhapsau) - ($request->qty[$i] * $giatra)) / ($sltontruoc + $slnhapsau - $request->qty[$i]);
        SettingPrice::where('id_material_detail',$request->idMaterial[$i])
                    ->update(['price' => round($price)]);
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
        $this->addExportCoupon($request);
        $this->addDetailExportCoupon($request,$count);
        $this->updateSettingPrice($count,$request);
        return redirect(route('exportcoupon.index'));
    }
    public function showIndex()
    {
        $exportCoupons = $this->getExportCoupons();
        return view('exportcoupon.index',compact('exportCoupons'));
    }

    public function destroyWarehouse($request)
    {
        return $this->exportMaterial($request);
    }

    public function viewDestroyCook($id)
    {
        $cook = CookArea::where('id',$id)->first();
        return view('warehouseexport.exportdestroycook',compact('cook'));
    }
    public function addDetailExportCouponDestroyCook($request,$count)
    {
        for ($i=0; $i < $count; $i++) {
            $detailExportCoupon = new ExportCouponDetail();
            $detailExportCoupon->code_export = $request->code;
            $detailExportCoupon->id_object = $request->type_object;
            $detailExportCoupon->id_material_detail = $request->idMaterial[$i];
            $detailExportCoupon->qty = $request->qty[$i];
            $detailExportCoupon->id_unit = $request->id_unit[$i];
            $this->checkTypeExport($request->id_kind,$request,$i);
            $this->substractQtyWarehouseCook($request->idMaterial[$i],$request->type_object,$request->qty[$i]);
            //$detailExportCoupon->save();
        }
    }
    public function destroyCook($request)
    {
        $count = $this->countMaterialExport($request);
        $this->addExportCoupon($request);
        $this->addDetailExportCouponDestroyCook($request,$count);
        return redirect(route('exportcoupon.index'));
    }
    public function printDetailExport($id)
    {
        $code = $this->getCodeById($id);
        $exportCoupon = ExportCoupon::where('code',$code->code)
                                        ->with('typeExport',
                                            'detailExportCoupon.cook',
                                            'detailExportCoupon.supplier',
                                            'detailExportCoupon.unit',
                                            'detailExportCoupon.materialDetail')
                                        ->get();
        //dd($exportCoupon);
        return view('exportcoupon.print',compact('exportCoupon'));
    }


}
