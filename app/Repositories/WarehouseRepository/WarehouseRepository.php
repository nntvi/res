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
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class WarehouseRepository extends Controller implements IWarehouseRepository{

    public function checkRoleIndex($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "XEM_KHO"){
                $temp++;
            }
        }
        return $temp;
    }

    public function checkRoleUpdate($arr)
    {
        $temp = 0;
        for ($i=0; $i < count($arr); $i++) {
            if($arr[$i] == "XEM_FULL" || $arr[$i] == "SUA_KHO"){
                $temp++;
            }
        }
        return $temp;
    }



    public function getTypes()
    {
        $types = TypeMaterial::with('warehouse')->get();
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
        $warehouse = WareHouse::whereBetween('updated_at',[$dateStart . $s , $dateEnd . $e])->with('detailMaterial','typeMaterial','unit')
                                    ->orderBy('id_material_detail')->get();
        return $warehouse;
    }

    public function importBetween($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailImport = ImportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->groupBy('id_material_detail')->orderBy('id_material_detail')->get();
        return $detailImport;
    }

    public function exportBetween($dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->groupBy('id_material_detail')->orderBy('id_material_detail')->get();
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
                'name' => $wh->detailMaterial->status == '1' ? $wh->detailMaterial->name : $wh->detailMaterial->name . ' (ko còn sử dụng)',
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
        $today = Carbon::now('Asia/Ho_Chi_Minh')->toDayDateTimeString();
        return view('warehouse.report',compact('arrayReport','dateStart','dateEnd','today'));
    }

    public function getImportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailImport = ImportCouponDetail::where('id_material_detail',$id)->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])->get();
        return $detailImport;
    }

    public function getExportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::where('id_material_detail',$id)->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->with('exportCoupon.typeExport')->get();
        return $detailExport;
    }

    public function warehouseDetailReportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $warehouse = WareHouse::whereBetween('updated_at',[$dateStart . $s , $dateEnd . $e])
                                    ->where('id_material_detail',$id)->with('detailMaterial','unit')->first();
        return $warehouse;
    }
    public function importDetailReportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailImport = ImportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->where('id_material_detail',$id)->groupBy('id_material_detail')->first();
        return $detailImport;
    }
    public function exportDetailReportById($id,$dateStart,$dateEnd)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$dateStart . $s, $dateEnd . $e])
                                            ->where('id_material_detail',$id)->groupBy('id_material_detail')->first();
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
        $a = ImportCoupon::with('detailImportCoupon.materialDetail','supplier')->whereBetween('created_at',[$dateStart,$dateEnd])
                            ->whereHas('detailImportCoupon', function ($query) use ($id)
                            {
                                $query->where('id_material_detail',$id);
                            })->get();
        return $a;
    }

    public function exportCoupon($id,$dateStart,$dateEnd)
    {
        $a = ExportCoupon::with('detailExportCoupon.materialDetail','typeExport')->whereBetween('created_at',[$dateStart,$dateEnd])
                        ->whereHas('detailExportCoupon', function ($query) use ($id)
                        {
                            $query->where('id_material_detail',$id);
                        })->get();
        return $a;
    }

    public function checkTonDauKy($warehouse,$detailImportById,$detailExportById)
    {
        // tdk = tck + x - n
        if($detailImportById == null){ // chưa nhập
            return $tondauky = $this->calculateTonDauKyById($warehouse->qty,$detailExportById->total,0);
        }
        if($detailExportById == null){ // chưa xuất
            return $tondauky = $this->calculateTonDauKyById($warehouse->qty,0,$detailImportById->total);
        }
        else if($detailImportById != null && $detailExportById != null){
            return $tondauky = $this->calculateTonDauKyById($warehouse->qty,$detailExportById->total,$detailImportById->total);
        }
    }
    public function getInfoImport($dateStart,$dateEnd,$id,$code)
    {
        $infoImports = ImportCouponDetail::whereBetween('created_at',[$dateStart, $dateEnd])
                        ->where('code_import',$code)->where('id_material_detail',$id)
                        ->with('materialDetail','unit')->get();
        return $infoImports;
    }
    public function getInfoExport($dateStart,$dateEnd,$id,$code)
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $infoExports = ExportCouponDetail::whereBetween('created_at',[$dateStart . $s , $dateEnd . $e])
                        ->where('code_export',$code)->where('id_material_detail',$id)
                        ->with('materialDetail','unit')->get();
        return $infoExports;
    }
    public function createDataImportAndExport($array,$data)
    {
        foreach ($array as $key => $value) {
            array_push($data,$value);
        }
        return $data;
    }

    public function paginate($items, $perPage = 7, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function getDetailReport($id,$dateStart,$dateEnd)
    {
        $data = array(); $infoImpArr = array(); $infoExArr = array();$info = array();
        $detailImport = $this->getImportById($id,$dateStart,$dateEnd);
        $detailExport = $this->getExportById($id,$dateStart,$dateEnd);
        $warehouse = $this->warehouseDetailReportById($id,$dateStart,$dateEnd); // tính đến thời điểm hiện tại kho còn bao nhiêu => tồn cuối kì
        $detailImportById = $this->importDetailReportById($id,$dateStart,$dateEnd);
        $detailExportById = $this->exportDetailReportById($id,$dateStart,$dateEnd);
        $importCoupon = $this->importCoupon($id,$dateStart,$dateEnd);
        $exportCoupon = $this->exportCoupon($id,$dateStart,$dateEnd);
        $tondauky = $this->checkTonDauKy($warehouse,$detailImportById,$detailExportById);
        $data = $this->createDataImportAndExport($importCoupon,$data);
        $data = $this->createDataImportAndExport($exportCoupon,$data);
        $data = $this->paginate($data)->setPath(route('reportwarehouse.detail',['id' => $id,'dateStart' => $dateStart,'dateEnd' => $dateEnd]));

        return view('warehouse.reportdetail',compact('detailImport','detailExport', 'warehouse','detailImportById',
                                                    'detailExportById','tondauky', 'dateStart','dateEnd', 'data','info'));
    }
}
