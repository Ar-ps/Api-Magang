<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_asset_number',
        'external_asset_date',
        'currency_code',
        'transaction_type',
        'receiver_code',
        'output_type',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(ExternalAssetItem::class, 'external_asset_id');
    }
}
