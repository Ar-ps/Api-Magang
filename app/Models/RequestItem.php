<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'item_code',
        'quantity',
        'received',
        'soc_number',
        'production_planning_number',
        'product_code',
        'notes',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}
