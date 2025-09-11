<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiData extends Model
{
    protected $fillable = ['module', 'payload'];
    protected $casts = [
        'payload' => 'array',
    ];
}

