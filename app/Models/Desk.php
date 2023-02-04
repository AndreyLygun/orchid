<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use App\Busboy\Multitenant;

class Desk extends Model
{
    use HasFactory;
    use AsSource;
    use Multitenant;

    protected $guarded=['id', 'company_id'];
    public function qrs() {
        return $this->hasMany(Qr::class);
    }
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
