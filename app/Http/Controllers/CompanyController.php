<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function showInfo() {
        return session('company_id');
    }

    public function showMenu() {
        $menu = Category::with('Dishes')->orderBy('order')->get()->toArray();
        return view('visit.menu', ['menu' => $menu]);
    }

    public function showOrder() {
        return session('company_id');
    }

    public function showWaiter() {
        return session('company_id');
    }
}
