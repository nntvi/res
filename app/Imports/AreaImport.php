<?php

namespace App\Imports;

use App\Area;
use Maatwebsite\Excel\Concerns\ToModel;

class AreaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Area([
            //
        ]);
    }
}
