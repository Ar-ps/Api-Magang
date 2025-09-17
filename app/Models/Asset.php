<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'api_id',
        'asset_date',
        'entry_date',
        'sender_code',
        'asset_number',
        'currency_code',
        'confirmation_id',
        'transaction_type',
        'confirmation_date',
        'confirmation_status',
    ];

    public function details()
    {
        return $this->hasMany(AssetDetailItem::class);
    }
}
