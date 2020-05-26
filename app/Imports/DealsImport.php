<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\PromoWithoutHeadingImport;
use App\Imports\PromoWithHeadingImport;

class DealsImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            'rule' => new PromoWithoutHeadingImport(),
            'outlet' => new PromoWithHeadingImport(),
            'content' => new PromoWithHeadingImport(),
            3 => new PromoWithHeadingImport()
        ];
    }
}
