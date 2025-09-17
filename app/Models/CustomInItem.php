<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomInItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_in_id',
        'item_code',
        'quantity',
        'unit_price',
        'total_price',
        'hs_code',
        'series_number',
        'exchange_rate',
        'invoice_number',
        'invoice_date',
        'soc_number',
        'production_planning_number',
        'order_document_code',
        'product_code',
        'notes',
    ];

    public function custom()
    {
        return $this->belongsTo(CustomIn::class, 'custom_in_id');
    }
}
