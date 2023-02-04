<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Company extends Model
{
    use HasFactory;
    use AsSource;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = '';

    public function Menus() {
        return $this->hasMany(Category::class);
    }
    public function Desks() {
        return $this->hasMany(Desk::class);
    }
    public function Staff() {
        return $this->hasMany(Staff::class);
    }
}
