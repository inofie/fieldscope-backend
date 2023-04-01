<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class CategoryTagSampleExport implements WithMultipleSheets,FromArray {

    use Exportable;

    protected $reqPhotos , $sheets;
    public function __construct(Collection  $reqPhotos)
    {
        $this->reqPhotos = $reqPhotos;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[]= $this->array();

        return $sheets;
    }

    public function array() :array{
        return [
            ['a1','b1','c1','d1','e1','f1'],
            ['a1','b1','c1','d1','e1','f1'],
        ];
    }




}

