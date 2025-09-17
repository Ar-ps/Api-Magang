<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalAssetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_asset_id',
        'item_code',
        'quantity',
        'unit_price',
        'total_price',
        'order_asset_number',
        'notes',
    ];

    public function externalAsset()
    {
        return $this->belongsTo(ExternalAsset::class, 'external_asset_id');
    }
}
