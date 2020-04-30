<?php

namespace App\Exports;

use App\OrderDetailTable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportDishExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct(string $dateStart, string $dateEnd, int $idGroupMenu)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->idGroupMenu = $idGroupMenu;
    }

    public function getResult()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        if($this->idGroupMenu == '0'){
            $results = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')
                        ->whereBetween('updated_at',[$this->dateStart . $s ,$this->dateEnd . $e])
                        ->groupBy('id_dish')
                        ->with('dish','dish.groupMenu','dish.unit')
                        ->get();
        }
        else{
            $results = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')
                        ->whereBetween('updated_at',[$this->dateStart . $s ,$this->dateEnd . $e])
                        ->groupBy('id_dish')
                        ->with('dish','dish.groupMenu','dish.unit')
                        ->whereHas('dish.groupMenu', function($query) {
                            $query->where('id',$this->idGroupMenu);
                        })->get();
        }
        return $results;
    }
    public function collection()
    {
        $results = $this->getResult();
        foreach ($results as $key => $item) {
            $row[] = array(
                '0' => $key + 1,
                '1' => $item->dish->code,
                '2' => $item->dish->groupMenu->name,
                '3' => $item->dish->name,
                '4' => $item->dish->unit->name,
                '5' => $item->sumQty,
                '6' => $item->dish->capital_price,
                '7' => $item->dish->sale_price,
                '8' => (($item->dish->sale_price) - ($item->dish->capital_price)) * $item->sumQty
            );
        }
        return collect($row);
    }

    public function headings() : array
    {
        return [
            'STT',
            'Mã món ăn',
            'Nhóm thực đơn',
            'Tên món',
            'Đơn vị tính',
            'Số lượng',
            'Giá vốn',
            'Giá bán',
            'Lợi nhuận',
        ];
    }
}
