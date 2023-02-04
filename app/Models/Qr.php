<?php

namespace App\Models;

use App\Busboy\Multitenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Qr extends Model
{
    use HasFactory;
    use AsSource;
    use Multitenant;

    public $guarded = ['id', 'company_id'];

    function qrcode() {
        return $this->id . $this->code;
    }

    function desk() {
        return $this->belongsTo(Desk::class);
    }
}
