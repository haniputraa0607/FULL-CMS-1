<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\PromoSheet;

class DealsExport implements WithMultipleSheets
{
    use Exportable;

    protected $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->data as $key => $value) {
	        // sheet title maksimal 31 caracter
            if ($key == 'rule') 
            {
	            $sheets[] = new PromoSheet($value, substr($key,0,30), 'rule');	
            }
            elseif ($key == 'content') 
            {
	            $sheets[] = new PromoSheet($value, substr($key,0,30), 'content');	
            }
            else
            {
	            $sheets[] = new PromoSheet($value, substr($key,0,30));
            }
        }

        return $sheets;
    }
}
