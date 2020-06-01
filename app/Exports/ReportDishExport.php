<?php

namespace App\Exports;

use App\GroupMenu;
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

    public function getNameGroupMenu($idGroupMenu)
    {
       $name = GroupMenu::where('id',$idGroupMenu)->value('name');
       return $name;
    }
    public function getResult()
    {
        if($this->idGroupMenu == '0'){
            $results = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')
                        ->whereBetween('updated_at',[$this->dateStart,$this->dateEnd])
                        ->whereIn('status',['1','2'])
                        ->groupBy('id_dish')
                        ->with('dish','dish.groupMenu','dish.unit')
                        ->get();
        }
        else{
            $results = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')
                        ->whereBetween('updated_at',[$this->dateStart,$this->dateEnd])
                        ->whereIn('status',['1','2'])
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
            ['Báo cáo Món ăn'],
            ['Từ',$this->dateStart],
            ['Đến',$this->dateEnd],
            ['Danh mục',$this->idGroupMenu == '0' ? 'Tất cả' : $this->getNameGroupMenu($this->idGroupMenu)],
            [],
            [
                'STT',
                'Mã món ăn',
                'Nhóm thực đơn',
                'Tên món',
                'Đơn vị tính',
                'Số lượng',
                'Giá vốn',
                'Giá bán',
                'Lợi nhuận',
            ],
        ];
    }
}
