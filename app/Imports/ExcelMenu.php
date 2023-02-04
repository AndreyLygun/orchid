<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Facades\Excel;


class ExcelMenu implements WithHeadingRow, FromCollection
{
    /**
    * @param Collection $rows
    */
    use Importable;
    public function headingRow(): int
    {
        return 2;
    }

    public function makeDish($row) {
        $dish =['name' => $row[2],
                'shortname' => $row[3],
                'category_id' => $row[1],
                'description' => $row[4],
                'alias' => '',
                'hide' => $row[13],
                'article' => $row[5],
                'photo' => $row[11],
                'options' => $row[12],
                'price' => $row[7],
                'out_price' => $row[7],
                'change_price' => $row[8],
                'hall' => 1,
                'pickup' => 1,
                'delivery' => 1,
                'size' => $row[6],
                'kbju' => $row[10],
                'recomendation' => $row[14],
                'timing' => $row[15],
                'special' => $row[14],
            ];
        return $dish;
    }

    public function Import($fileName, $menuName) {
        $book = Book::FirstOrCreate(['name'=>$menuName]);
        $sheets = Excel::toArray($this, $fileName);
        $order = 0;
        $count = 0;
        foreach ($sheets[0] as $row) {
            $dish = $this->makeDish($row);
            $categoryName = $dish['category_id'];
            $category = Category::firstOrCreate(['name'=>$categoryName], ['order'=>$order++, 'book_id'=>$book->id]);
            $dish['category_id'] = $category->id;
            $dish['order'] = $order++;
            Dish::firstOrCreate(['name'=>$dish['name']], $dish);
            $count++;
        }
        return $count;
    }

    public function collection()
    {
        return Invoice::all();
    }

}
