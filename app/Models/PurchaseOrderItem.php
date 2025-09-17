<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'item_code',
        'quantity',
        'unit_price',
        'total_price',
        'received_quantity',
        'remaining_quantity',
        'soc_number',
        'production_planning_number',
        'product_code',
        'notes',
    ];

    public function order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }
}
