<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'receipt_date',
        'sender_code',
        'currency_code',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class);
    }
}
