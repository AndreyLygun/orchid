<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use App\Busboy\Multitenant;

class Staff extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Multitenant;

    public $guarded = ['id', 'company_id'];
    protected $allowedFilters = [
        'id',
        'name',
        'phone'
    ];
    protected $allowedSorts  = [
        'id',
        'name',
        'phone'
    ];

}
