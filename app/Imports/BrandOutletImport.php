<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class BrandOutletImport implements WithMultipleSheets
{
   
    public function sheets(): array
    {
        HeadingRowFormatter::default('none');
        return [
            0=>new ExcelImport()
        ];
    }
}
