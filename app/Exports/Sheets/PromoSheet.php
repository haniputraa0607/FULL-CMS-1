<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PromoSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
    private $data;
    private $title;
    Private $sheet_name;

    public function __construct(array $data, $title='', $sheet_name=null)
    {
        $this->data 		= $data;
        $this->title  		= $title;
        $this->sheet_name  	= $sheet_name;
    }

    public function array(): array
    {
    	return $this->data;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
    	$heading = [];
    	if (empty($this->sheet_name) ) {
    		$heading = $this->data[0]??[];
    	}
    	elseif ($this->sheet_name == 'content') {
    		$heading = [
    			'title' 		=> null,
    			'visibility' 	=> null,
    			'detail' 		=> null
    		];
    	}

        return array_keys($heading);
    }
}