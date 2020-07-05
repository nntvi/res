<?php

namespace App\Exports;

use App\OrderDetailTable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportDestroyDish implements FromCollection, WithHeadings
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

    public function getDishDestroy($status)
    {
        $dishEmpty = OrderDetailTable::selectRaw('id_dish, sum(qty) as qty')->whereBetween('updated_at',[$this->dateStart,$this->dateEnd])
                            ->where('status',$status)->groupBy('id_dish')->with('dish.groupMenu.cookArea','dish.unit')->get();
        return $dishEmpty;
    }

    public function getDishDestroyByIdGroupMenu($status)
    {
        $dishEmpty = OrderDetailTable::selectRaw('id_dish, sum(qty) as qty')->whereBetween('updated_at',[$this->dateStart,$this->dateEnd])
                            ->where('status',$status)->groupBy('id_dish')
                            ->whereHas('dish.groupMenu', function($query) {
                                $query->where('id',$this->idGroupMenu);
                            })->with('dish.groupMenu.cookArea','dish.unit')->get();
        return $dishEmpty;
    }

    public function createArrayDestroyDish($array,$results,$status)
    {
        foreach ($array as $key => $item) {
            $temp = [
                'code' => $item->dish->code,
                'name' => $item->dish->name,
                'groupmenu' => $item->dish->groupMenu->name,
                'cook' => $item->dish->groupMenu->cookArea->name,
                'unit' => $item->dish->unit->name,
                'qty' => $item->qty,
                'status' => $status == '-3' ? 'Hết NVL ở kho' : ($status == '-2' ? 'Món hủy chọn' : 'Bếp hết NVL'),
            ];
            array_push($results,$temp);
        }
        return $results;
    }

    public function getResult()
    {
        $results = array();
        if ($this->idGroupMenu == '0') {
            $results = $this->createArrayDestroyDish($this->getDishDestroy('-1'),$results,'-1');
            $results = $this->createArrayDestroyDish($this->getDishDestroy('-3'),$results,'-3');
            $results = $this->createArrayDestroyDish($this->getDishDestroy('-2'),$results,'-2');
        } else {
            $results = $this->createArrayDestroyDish($this->getDishDestroyByIdGroupMenu('-1'),$results,'-1');
            $results = $this->createArrayDestroyDish($this->getDishDestroyByIdGroupMenu('-3'),$results,'-3');
            $results = $this->createArrayDestroyDish($this->getDishDestroyByIdGroupMenu('-2'),$results,'-2');
        }
        return $results;
    }

    public function collection()
    {
        $results = $this->getResult();
        foreach ($results as $key => $item) {
            $row[] = array(
                '0' => $key + 1,
                '1' => $item['code'],
                '2' => $item['name'],
                '3' => $item['groupmenu'],
                '4' => $item['cook'],
                '5' => $item['unit'],
                '6' => $item['qty'],
                '7' => $item['status'],
            );
        }
        return collect($row);
    }

    public function headings() : array
    {
        return [
            ['Báo cáo Món ăn đã hủy'],
            ['Từ',$this->dateStart,'Đến',$this->dateEnd],
            [],
            [
                'STT',
                'Mã món ăn',
                'Tên món',
                'Nhóm thực đơn',
                'Thuộc bếp',
                'Đơn vị tính',
                'Số lượng',
                'Lý do hủy'
            ],
        ];
    }
}
