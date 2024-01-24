<?php

// MasterTimbanganExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class MasterTimbanganExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        // Customize the column headings as needed
        return [
            'FLAG1',
            'FLAG2',
            'PLU',
            'ITEM CODE',
            'COMM NAME',
            'UNIT PRICE',
            'USED DATE',
            'SPECIAL MESSAGE',
            'WEIGHT TYPE',
        ];
    }
}


