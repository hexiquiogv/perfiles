<?php

namespace App\Exports;

use App\Models\CustomModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CustomExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct($data)
    {
        $this->data = $data;        
    }
    
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return explode(",", implode(",",array_keys($this->data->first()->toArray())) );
    }

    public function title(): string
    {
        return 'Hoja1';
    }
}
