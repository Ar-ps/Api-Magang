<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crm extends Model
{
    use HasFactory;

    protected $fillable = [
        'crm_number',
        'interaction_date',
        'entity_code',
        'interaction_media',
        'customer_team',
        'internal_team',
        'negotiation',
        'isorder',
    ];
}
