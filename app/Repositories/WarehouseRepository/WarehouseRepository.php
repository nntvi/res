<?php
namespace App\Repositories\WarehouseRepository;

use App\ExportCoupon;
use App\Http\Controllers\Controller;
use App\WareHouse;
use App\Supplier;
use App\MaterialDetail;
use App\TypeMaterial;
use App\Unit;
use App\WareHouseDetail;
use App\ImportCouponDetail;
use App\ExportCouponDetail;
use App\ImportCoupon;
use Illuminate\Support\Facades\DB;

class WarehouseRepository extends Controller implements IWarehouseRepository{

    public function getTypes()
    {
        $types = TypeMaterial::all();
        return $types;
    }
    public function showIndex()
    {
       $types = $this->getTypes();
        return view('warehouse.index',compact('types'));
    }
    public function updateLimitStockWarehouse($request,$id)
    {
        WareHouse::where('id',$id)->update(['limit_stock' => $request->limitStock]);
        return redirect(route('warehouse.index'));
    }
    public function warehouseBetweenTime($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $warehouse = WareHouse::whereBetween('updated_at',[$dateStart . $s , $dateEnd . $e])
                                    ->with('detailMaterial','typeMaterial','unit')
                                    ->orderBy('id_material_detail')
                                    ->get();
        return $warehouse;
    }

    public function importBetween($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailImport = ImportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->groupBy('id_material_detail')
                                            ->orderBy('id_material_detail')
                                            ->get();
        return $detailImport;
    }

    public function exportBetween($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->groupBy('id_material_detail')
                                            ->orderBy('id_material_detail')
                                            ->get();
        return $detailExport;
    }
    public function getValueImport($idMaterialDetail,$detailImport)
    {
        $temp = 0;
        for ($i=0; $i < count($detailImport); $i++) {
            if ($detailImport[$i]->id_material_detail == $idMaterialDetail) {
                return $detailImport[$i]->total;
                break;
            } else {
                $temp++;
            }
        }
        if($temp == count($detailImport)){
            return 0;
        }
    }
    public function getValueExport($idMaterialDetail,$detailExport)
    {
        $temp = 0;
        for ($i=0; $i < count($detailExport); $i++) {
            if ($detailExport[$i]->id_material_detail == $idMaterialDetail) {
                return $detailExport[$i]->total;
                break;
            } else {
                $temp++;
            }
        }
        if($temp == count($detailExport)){
            return 0;
        }
    }
    public function getTonDauKy($toncuoiky, $xuat, $nhap) {
        return $toncuoiky + $xuat - $nhap;
    }

    public function getReportWarehouse($warehouse,$detailImport,$detailExport)
    {
        $data = array();
        $tempArray = array();
        foreach ($warehouse as $key => $wh) {
            $tempArray = [
                'stt' => $key+1,
                'idMaterialDetail' => $wh->id_material_detail,
                'name' => $wh->detailMaterial->name,
                'nameType' => $wh->typeMaterial->name,
                'unit' => $wh->unit->name,
                'tondauky' => $this->getTonDauKy($wh->qty,$this->getValueExport($wh->id_material_detail,$detailExport),
                                                            $this->getValueImport($wh->id_material_detail,$detailImport)),
                'import' => $this->getValueImport($wh->id_material_detail,$detailImport),
                'export' => $this->getValueExport($wh->id_material_detail,$detailExport),
                'toncuoiky' => $wh->qty
            ];
            array_push($data,$tempArray);
            unset($tempArray);
        }
        return $data;
    }

    public function reportWarehouse($request)
    {
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $warehouse = $this->warehouseBetweenTime($dateStart,$dateEnd);
        $detailImport = $this->importBetween($dateStart,$dateEnd);
        $detailExport = $this->exportBetween($dateStart,$dateEnd);
        $arrayReport = $this->getReportWarehouse($warehouse,$detailImport,$detailExport);
        return view('warehouse.report',compact('arrayReport','dateStart','dateEnd'));
    }

    public function getImportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailImport = ImportCouponDetail::where('id_material_detail',$id)
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->with('importCoupon.supplier')
                                            ->get();
        return $detailImport;
    }

    public function getExportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::where('id_material_detail',$id)
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->with('exportCoupon.typeExport')
                                            ->get();
        return $detailExport;
    }

    public function warehouseDetailReportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $warehouse = WareHouse::whereBetween('updated_at',[$dateStart . $s , $dateEnd . $e])
                                    ->where('id_material_detail',$id)
                                    ->with('detailMaterial')
                                    ->first();
        return $warehouse;
    }
    public function importDetailReportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailImport = ImportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->where('id_material_detail',$id)
                                            ->groupBy('id_material_detail')
                                            ->first();
        return $detailImport;
    }
    public function exportDetailReportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->where('id_material_detail',$id)
                                            ->groupBy('id_material_detail')
                                            ->first();
        return $detailExport;
    }
    public function calculateTonDauKyById($tck,$xuat,$nhap)
    {
        return $tck + $xuat - $nhap;
    }

    public function importCoupon($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $a = DB::table('import_coupons')
                ->join('detail_import_coupon', 'detail_import_coupon.code_import', '=', 'import_coupons.code')
                ->join('suppliers','suppliers.id','=','import_coupons.id_supplier')
                ->where('detail_import_coupon.id_material_detail',$id)
                ->whereBetween('import_coupons.created_at',[$dateStart . $s , $dateEnd . $e])
                ->get();
        return $a;
    }

    public function exportCoupon($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $a = DB::table('export_coupons')
                ->join('detail_export_coupon', 'detail_export_coupon.code_export', '=', 'export_coupons.code')
                ->join('type_export','type_export.id','=','export_coupons.id_type')
                ->where('detail_export_coupon.id_material_detail',$id)
                ->whereBetween('export_coupons.created_at',[$dateStart . $s , $dateEnd . $e])
                ->get();
        return $a;
    }

    public function checkTonDauKy($warehouse,$detailImportById,$detailExportById)
    {
        if($detailImportById == null){
            return $tondauky = $this->calculateTonDauKyById($warehouse->qty,$detailExportById->total,0);
        }
        if($detailExportById == null){
            return $tondauky = $this->calculateTonDauKyById($warehouse->qty,0,$detailImportById->total);
        }
        else if($detailImportById != null && $detailExportById != null){
            return $tondauky = $this->calculateTonDauKyById($warehouse->qty,$detailExportById->total,$detailImportById->total);
        }
    }
    public function getInfoImport($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $infoImports = ImportCoupon::whereBetween('created_at',[$dateStart . $s , $dateEnd . $e])
                                ->with('detailImportCoupon.materialDetail','detailImportCoupon.unit')
                                ->get();
        return $infoImports;
    }
    public function getInfoExport($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $infoExports = ExportCoupon::whereBetween('created_at',[$dateStart . $s , $dateEnd . $e])
                                    ->with('detailExportCoupon.materialDetail','detailExportCoupon.unit')
                                    ->get();
        return $infoExports;
    }
    public function getDetailReport($id,$dateStart,$dateEnd)
    {
        $detailImport = $this->getImportById($id,$dateStart,$dateEnd);
        $detailExport = $this->getExportById($id,$dateStart,$dateEnd);
        $warehouse = $this->warehouseDetailReportById($id,$dateStart,$dateEnd);
        $detailImportById = $this->importDetailReportById($id,$dateStart,$dateEnd);
        $detailExportById = $this->exportDetailReportById($id,$dateStart,$dateEnd);
        $importCoupon = $this->importCoupon($id,$dateStart,$dateEnd);
        $count = count($importCoupon)+1;
        $exportCoupon = $this->exportCoupon($id,$dateStart,$dateEnd);
        $tondauky = $this->checkTonDauKy($warehouse,$detailImportById,$detailExportById);
        $infoImports = $this->getInfoImport($dateStart,$dateEnd);
        $infoExports = $this->getInfoExport($dateStart,$dateEnd);
        //dd($infoExports);
        return view('warehouse.reportdetail',compact('detailImport','detailExport',
                                                    'warehouse','detailImportById',
                                                    'detailExportById','tondauky',
                                                    'dateStart','dateEnd',
                                                    'importCoupon','exportCoupon','count',
                                                    'infoImports','infoExports'));
    }
}
