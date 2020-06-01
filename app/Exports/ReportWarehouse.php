<?php

namespace App\Exports;

use App\WareHouse;
use App\ExportCouponDetail;
use App\ImportCouponDetail;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportWarehouse implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct(string $dateStart, string $dateEnd)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function warehouseBetweenTime()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $warehouse = WareHouse::whereBetween('updated_at',[$this->dateStart . $s ,$this->dateEnd . $e])
                                    ->with('detailMaterial','typeMaterial','unit')
                                    ->orderBy('id_material_detail')->get();
        return $warehouse;
    }

    public function importBetween()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailImport = ImportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$this->dateStart . $s ,$this->dateEnd . $e])
                                            ->groupBy('id_material_detail')->orderBy('id_material_detail')->get();
        return $detailImport;
    }

    public function exportBetween()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $detailExport = ExportCouponDetail::selectRaw('id_material_detail, sum(qty) as total')
                                            ->whereBetween('created_at',[$this->dateStart . $s ,$this->dateEnd . $e])
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

    public function collection()
    {
        $warehouse = $this->warehouseBetweenTime();
        $detailImport = $this->importBetween();
        $detailExport = $this->exportBetween();
        $arrayReport = $this->getReportWarehouse($warehouse,$detailImport,$detailExport);
        foreach ($arrayReport as $key => $item) {
            $row[] = array(
                '0' => $key + 1,
                '1' => $item['name'],
                '2' => $item['nameType'],
                '3' => $item['unit'],
                '4' => $item['tondauky'] == 0 ? '0' : $item['tondauky'],
                '5' => $item['import'] == 0 ? '0' : $item['import'],
                '6' => $item['export'] == 0 ? '0' : $item['export'],
                '7' => $item['toncuoiky'] == 0 ? '0' : $item['toncuoiky'],
            );
        }
        return collect($row);
    }

    public function headings() : array
    {
        return [
            ['Báo cáo kho'],
            ['Từ', $this->dateStart],
            ['Đến',$this->dateEnd],
            [],
            [
                'STT',
                'Tên NVL',
                'Nhóm thực đơn',
                'Đơn vị tính',
                'Tồn đầu kì',
                'SL nhập',
                'SL xuất',
                'Tồn cuối kỳ'
            ],
        ];
    }
}
