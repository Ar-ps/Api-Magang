<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_order_id',
        'item_code',
        'quantity',
        'unit_price',
        'total_price',
        'received_quantity',
        'remaining_quantity',
        'specification',
        'notes',
    ];

    public function assetOrder()
    {
        return $this->belongsTo(AssetOrder::class, 'asset_order_id');
    }
}
