<?php

namespace App\Exports;

use App\Area;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AreaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Area::orderBy('name', 'asc')->get();
    }

    public function headings() : array
    {
        return [
            'id', 'Tên khu vực'
        ];
    }
}
