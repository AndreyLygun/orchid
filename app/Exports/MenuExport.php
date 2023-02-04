<?php

namespace App\Exports;

use App\Models\Dish;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MenuExport implements FromCollection, WithHeadings, WithMapping
{



    /**
    * @return \Illuminate\Support\Collection
    */


    public function collection()
    {
        return Dish::with('Category')->get();
    }

    public function headings(): array
    {
        return Dish::FIELDS;
    }

    public function map($dish): array
    {

        $map = [];
        foreach (Dish::FIELDS as $field => $title) {
            $map[] = $dish->toArray()[$field];
        }
        return $map ;
    }
}
