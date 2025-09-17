<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_order_number',
        'asset_order_date',
        'sender_code',
        'reference_code',
        'currency_code',
        'confirmation_status',
        'entry_date',
        'order_type',
    ];

    public function items()
    {
        return $this->hasMany(AssetOrderItem::class, 'asset_order_id');
    }
}
