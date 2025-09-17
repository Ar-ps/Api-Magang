<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'goods_receipt_id',
        'item_code',
        'quantity',
        'invoice_number',
        'invoice_date',
        'soc_number',
        'production_planning_number',
        'order_document_number',
        'product_code',
        'custom_document_code',
        'registration_number',
        'custom_document_number',
        'custom_document_date',
        'receipt_notes',
    ];

    public function receipt()
    {
        return $this->belongsTo(GoodsReceipt::class);
    }
}
