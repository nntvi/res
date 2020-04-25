<?php

namespace App\Exports;

use App\GroupMenu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupMenuExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $groupmenus = GroupMenu::with('cookArea')->get();
        foreach ($groupmenus as $key => $row) {
            $groupmenu[] = array(
                '0' => $row->id,
                '1' => $row->name,
                '2' => $row->cookArea->name
            );
        }
        return collect($groupmenu);
    }

    public function headings() : array
    {
        return [
            'id',
            'Tên nhóm thực đơn',
            'Thuộc bếp'
        ];
    }
}
