<?php

namespace App\Exports;

use App\MaterialDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MaterialDetailExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $materialDetails = MaterialDetail::with('typeMaterial','unit')->orderBy('name','asc')->get();
        foreach ($materialDetails as $key => $row) {
            $materialDetail[] = array(
                '0' => $key + 1,
                '1' => $row->name,
                '2' => $row->typeMaterial->name,
                '3' => $row->unit->name
            );
        }
        return (collect($materialDetail));
    }
    public function headings() : array
    {
        return [
            'STT',
            'Tên NVL',
            'Thuộc nhóm',
            'Đơn vị'
        ];
    }
}
