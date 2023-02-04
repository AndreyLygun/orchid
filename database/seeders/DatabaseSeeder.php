<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Imports\ExcelMenu;
use App\Models\Company;
use App\Models\Staff;
use App\Models\Desk;
use App\Models\Qr;
use App\Models\Book;
use App\Models\Category;
use App\Models\Dish;
use Maatwebsite\Excel\Facades\Excel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    protected function createRestaurant($companyId, $staff, $desks, $menuFile, $additionalMenuFile='') {
        session(['company_id'=>$companyId]);
        $user = User::all()->where('name', $companyId)->first();
        Company::FirstOrCreate(['id'=>$companyId], ['name'=>$companyId, 'user_id' => $user->id]);
        $phone = 79261906286;
        foreach ($staff as $name) {
            Staff::FirstOrCreate(['name'=>$name], ['phone' => $phone++, 'company_id'=>'demo']);
        }
        foreach ($desks as $desk) {
            $desk = Desk::FirstOrCreate(['company_id' => $companyId, 'name' => $desk]);
            for($i=0; $i<3; $i++) {
                $code = rand(0, 99999999);
                Qr::FirstOrCreate(['code'=>$code], ['desk_id'=>$desk->id]);
            }
        }

        $menuImport = new ExcelMenu();
        $dishCount = $menuImport->import($menuFile, 'Основное');

        if ($additionalMenuFile) {
            $menuImport = new ExcelMenu();
            $dishCount += $menuImport->import($additionalMenuFile, 'Напитки');
        }

        echo "Создано меню из $dishCount блюд\n";
    }

    public function run()
    {
        $this->createRestaurant(
            'admin',
            ['Андрей', 'Лена', 'Наташа', 'Вася'],
            ['Первый', 'Второй', 'Третий', 'Четвёртый', 'Пятый', 'Шестой'],
            'menu-main.xls', 'menu-drinks.xls'
        );
        $this->createRestaurant(
            'test',
            ['Андрей1', 'Лена1', 'Наташа1', 'Вася1'],
            ['1', '2', '3', '4', '5', '6'],
            'menu-main.xls', 'menu-drinks.xls'
        );
    }
}
