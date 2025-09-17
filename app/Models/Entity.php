<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_code',
        'entity_name',
        'entity_address',
        'contact_person',
        'telephone',
        'fax',
        'email',
        'country_code',
        'npwp',
    ];
}
