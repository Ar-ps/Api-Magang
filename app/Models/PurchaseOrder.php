<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_document_number',
        'order_date',
        'required_date',
        'entity_code',
        'currency_code',
        'received_status',
        'entry_date',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
