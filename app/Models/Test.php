<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'user_id',
        'entry_date',
        'tenant_code',
    ];
}
