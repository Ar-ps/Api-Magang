<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_code',
        'item_name',
        'unit_code',
        'quantity',
        'unit_price',
        'total_price',
        'soc_number',
        'production_planning_number',
        'order_number',
        'product_code',
        'remarks',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
