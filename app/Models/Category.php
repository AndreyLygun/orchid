<?php

namespace App\Models;

use App\Busboy\Multitenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use HasFactory;
    use Multitenant;
    use AsSource;

    protected $guarded = ['company_id'];

    public function menu() {
        return $this->belongsTo(Book::class);
    }
    public function dishes() {
        return $this->hasMany(Dish::class)->orderBy('order');
    }
}
