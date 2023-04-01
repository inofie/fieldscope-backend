<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CategoryTagDataSheet implements FromArray,WithHeadings,withTitle
{
    public function array():array{

        $example[0][0] = '1';
        $example[0][1] = 'sample category name 1';
        $example[0][2] = 'Tag name 1';
        $example[0][3] = 'yes';
        $example[0][4] = 'yes';
        $example[0][5] = '2';

        $example[0][0] = '1';
        $example[0][1] = 'sample category name 1';
        $example[0][2] = 'Tag name 2';
        $example[0][3] = 'no';
        $example[0][4] = 'no';
        $example[0][5] = '7';

        $example[0][0] = '2';
        $example[0][1] = 'sample category name 2';
        $example[0][2] = 'Tag name 3';
        $example[0][3] = 'yes';
        $example[0][4] = 'no';
        $example[0][5] = '17';

        return $example;
    }


    public function headings(): array
    {
        return [
            'category_id',
            'category_name',
            'name',
            'has_qty',
            'is_required',
            'price',
        ];
    }

    public function title(): string
    {
        return 'Example';
    }
}
