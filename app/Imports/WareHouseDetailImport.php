<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\WareHouseDetail;
class WareHouseDetailImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function headingRow()
    {
        return 1;
    }
    public function model(array $row)
    {
        return new WareHouseDetail([
            'id_import' => $row[0],
            'id_good' => $row[1],
            'qty' => $row[2],
            'id_unit' => $row[3],
            'price' => $row[4]
        ]);
    }
}
