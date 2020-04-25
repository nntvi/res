<?php

namespace App\Exports;

use App\Dishes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DishExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $dishes = Dishes::with('groupNVL.groupMenu.cookArea','unit')->get();
        foreach ($dishes as $key => $row) {
            $dish[] = array(
                '0' => $key + 1,
                '1' => $row->code,
                '2' => $row->name,
                '3' => $row->sale_price,
                '4' => $row->capital_price,
                '5' => $row->groupNVL->groupMenu->name,
                '6' => $row->groupNVL->groupMenu->cookArea->name,
                '7' => $row->unit->name,
            );
        }
        return (collect($dish));
    }

    public function headings() : array
    {
        return [
            'STT',
            'Mã món ăn',
            'Tên món ăn',
            'Giá bán',
            'Giá vốn',
            'Nhóm thực đơn',
            'Thuộc bếp',
            'Đơn vị bán'
        ];
    }
}
