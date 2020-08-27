<?php

namespace App\Exports;

use Carbon\Carbon;
use App\HistoryWhCook;
use App\WarehouseCook;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportWarehouseCook implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct(string $cook, string $dateStart, string $dateEnd)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->cook = $cook;
    }

    public function getListQtyFirstPeriod()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $fisrtQtyList = HistoryWhCook::selectRaw('id_material_detail, sum(first_qty) as qty')
                                ->whereBetween('created_at',[$this->dateStart . $s ,$this->dateEnd . $e])
                                ->where('id_cook',$this->cook)->groupBy('id_material_detail')->get();
        return $fisrtQtyList;
    }
    public function getQtyFirstPeriodById($idMaterialDetail)
    {
        $list = $this->getListQtyFirstPeriod($this->cook);
        foreach ($list as $key => $value) {
            if($value->id_material_detail == $idMaterialDetail){
                return $value->qty;
                break;
            }
        }
    }
    public function getListQtyLastPeriod()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $lastQtyList = HistoryWhCook::selectRaw('id_material_detail, sum(last_qty) as qty')
                                ->whereBetween('updated_at',[$this->dateStart . $s ,$this->dateEnd . $e])
                                ->where('id_cook',$this->cook)->groupBy('id_material_detail')->get();
        return $lastQtyList;
    }
    public function getQtyLastPeriodById($idMaterialDetail)
    {
        $list = $this->getListQtyLastPeriod($this->cook);
        foreach ($list as $key => $value) {
            if($value->id_material_detail == $idMaterialDetail){
                return $value->qty;
                break;
            }
        }
    }

    public function getHistoryWhCook()
    {
        $histories = HistoryWhCook::selectRaw('id_material_detail')
                                ->whereBetween('created_at',[$this->dateStart,$this->dateEnd])
                                ->where('id_cook',$this->cook)->groupBy('id_material_detail')
                                ->with('detailMaterial.unit','detailMaterial.typeMaterial')->get();
        return $histories;
    }

    public function createArrayToReport()
    {
        $histories = $this->getHistoryWhCook($this->cook);
        $data = array();
        $temp = array();
        foreach ($histories as $key => $history) {
            $temp = [
                'stt' => $key + 1,
                'name_detail_material' => $history->detailMaterial->status == '1' ? $history->detailMaterial->name : $history->detailMaterial->name . ' (ko còn sử dụng)',
                'name_type_material' => $history->detailMaterial->typeMaterial->name,
                'name_unit' => $history->detailMaterial->unit->name,
                'tondauky' => $this->getQtyFirstPeriodById($history->id_material_detail,$this->dateStart,$this->dateEnd,$this->cook),
                'toncuoiky' => $this->getQtyLastPeriodById($history->id_material_detail,$this->dateStart,$this->dateEnd,$this->cook),
                'dasudung' => $this->getQtyFirstPeriodById($history->id_material_detail,$this->dateStart,$this->dateEnd,$this->cook) -
                            $this->getQtyLastPeriodById($history->id_material_detail,$this->dateStart,$this->dateEnd,$this->cook),
            ];
            array_push($data,$temp);
            unset($temp);
        }
        return $data;
    }
    public function collection()
    {
        $arrReport = $this->createArrayToReport();
        foreach ($arrReport as $key => $item) {
            $row[] = array(
                '0' => $item['stt'],
                '1' => $item['name_detail_material'],
                '2' => $item['name_type_material'],
                '3' => $item['tondauky'],
                '4' => $item['toncuoiky'],
                '5' => $item['dasudung'] == 0 ? '0' : $item['dasudung'],
                '6' => $item['name_unit'],
            );
        }
        return collect($row);
    }

    public function getTimeReport()
    {
        $dt = Carbon::now('Asia/Ho_Chi_Minh')->toDayDateTimeString();
        return $dt;
    }
    public function headings(): array
    {
        return [
            ['Bếp', $this->cook],
            ['Từ' , $this->dateStart],
            ['Đến', $this->dateEnd],
            [],
            [

                'STT',
                'Tên NVL',
                'Nhóm',
                'Tồn đầu kỳ',
                'Tồn cuối kỳ',
                'Đã sử dụng',
                'Đơn vị'

            ],
        ];

    }
}
