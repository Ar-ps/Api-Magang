<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalAssetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'internal_asset_id',
        'item_code',
        'quantity',
        'order_asset_number',
        'notes',
    ];

    public function internalAsset()
    {
        return $this->belongsTo(InternalAsset::class, 'internal_asset_id');
    }
}
