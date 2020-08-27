<?php

namespace App\Exports;

use App\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MaterialExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $materials = Material::with('groupMenu')->get();
        foreach ($materials as $key => $row) {
            $material[] = array(
                '0' => $key + 1,
                '1' => $row->name,
                '2' => $row->groupMenu->name
            );
        }
        return (collect($material));
    }

    public function headings() : array
    {
        return [
            'STT',
            'Tên món',
            'Tên nhóm thực đơn',
        ];
    }
}
