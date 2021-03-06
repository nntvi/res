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
                        ->selectRaw('sum(price * qty) as price')
                        ->selectRaw('sum(capital * qty) as capital')
                        ->whereBetween('updated_at',[$this->dateStart,$this->dateEnd])
                        ->whereIn('status',['1','2'])->groupBy('id_dish')
                        ->with('dish.groupMenu','dish.unit')->get();
        }
        else{
            $results = OrderDetailTable::selectRaw('id_dish, sum(qty) as sumQty')
                        ->selectRaw('sum(price * qty) as price')
                        ->selectRaw('sum(capital * qty) as capital')
                        ->whereBetween('updated_at',[$this->dateStart,$this->dateEnd])
                        ->whereIn('status',['1','2'])->groupBy('id_dish')
                        ->whereHas('dish.groupMenu', function($query){
                            $query->where('id',$this->idGroupMenu);
                        })->with('dish.groupMenu','dish.unit')->get();
        }
        return $results;
    }

    public function getTotalQtyDishToReport($results)
    {
        $totalQty = 0;
        foreach ($results as $key => $result) {
            $totalQty += $result['qty'];
        }
        return $totalQty;
    }

    public function getTotal()
    {
        $results = $this->getResult();
        $totalCapitalPrice = 0;$totalSalePrice = 0;$totalInterest = 0;
        foreach ($results as $key => $result) {
            $totalCapitalPrice += $result->capital;
            $totalSalePrice += $result->price;
            $totalInterest += ($result->price - $result->capital);
        }
        $footerReportDish = array();
        $temp = [
            'qty' => $this->getTotalQtyDishToReport($results),
            'totalCapital' => $totalCapitalPrice,
            'totalSale' => $totalSalePrice,
            'totalInterest' => $totalInterest
        ];
        array_push($footerReportDish,$temp);
        return $footerReportDish;
    }

    public function collection()
    {
        $results = $this->getResult();
        foreach ($results as $key => $item) {
            $row[] = array(
                '0' => $key + 1,
                '1' => $item->dish->code,
                '2' => $item->dish->groupMenu->name,
                '3' => $item->dish->stt == '1' ? $item->dish->name : $item->dish->name . '( ngưng phục vụ)',
                '4' => $item->dish->unit->name,
                '5' => $item->sumQty,
                '6' => $item->price,
                '7' => $item->capital,
                '8' => ($item->price - $item->capital),
            );
        }
        return collect($row);
    }

    public function headings() : array
    {
        $footer = $this->getTotal();
        return [
            ['Báo cáo Món ăn'],
            ['Từ',$this->dateStart,'Đến',$this->dateEnd],
            ['Tổng giá vốn',$footer[0]['totalCapital']],
            ['Tổng giá bán',$footer[0]['totalSale']],
            ['Tổng tiền lời',$footer[0]['totalInterest']],
            ['Danh mục',$this->idGroupMenu == '0' ? 'Tất cả' : $this->getNameGroupMenu($this->idGroupMenu)],
            [],
            [
                'STT',
                'Mã món ăn',
                'Nhóm thực đơn',
                'Tên món',
                'Đơn vị tính',
                'Số lượng',
                'Giá bán',
                'Giá vốn',
                'Lợi nhuận',
            ],
        ];
    }
}
