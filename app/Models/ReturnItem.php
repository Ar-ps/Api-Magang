<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_id',
        'item_code',
        'quantity',
        'receipt_number',
        'soc_number',
        'production_planning_number',
        'order_document_number',
        'product_code',
        'return_reason',
    ];

    public function retur()
    {
        return $this->belongsTo(ReturnModel::class, 'return_id');
    }
}
