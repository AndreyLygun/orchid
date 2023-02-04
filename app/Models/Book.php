<?php

namespace App\Models;

use App\Busboy\Multitenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Book extends Model
{
    use HasFactory;
    use Multitenant;
    use AsSource;

    protected  $guarded = ['id', 'company_id'];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function isActive($time = 0) {
        if (!$time) $time = time();

    }
}
