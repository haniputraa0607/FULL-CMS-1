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
    Private $use_heading;

    public function __construct(array $data, $title='', $use_heading=0)
    {
        $this->data = $data;
        $this->title  = $title;
        $this->use_heading  = $use_heading;
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
    	if ($this->use_heading == 1) 
    	{
    		$heading = $this->data[0]??[];
    	}

        return array_keys($heading);
    }
}