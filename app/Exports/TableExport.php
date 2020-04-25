<?php

namespace App\Exports;

use App\Table;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TableExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tables = Table::with('getArea')->orderBy('code')->get();
        foreach ($tables as $key => $row) {
            $table[] = array(
                '0' => $key + 1,
                '1' => $row->code,
                '2' => $row->name,
                '3' => $row->getArea->name
            );
        }
        return (collect($table));
    }

    public function headings() : array
    {
        return [
            'STT',
            'Mã bàn',
            'Tên bàn',
            'Tên khu vực'
        ];
    }
}
