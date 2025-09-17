<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_number',
        'asset_date',
        'currency_code',
        'transaction_type',
        'entry_date',
        'sender_code',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(AssetInItem::class, 'asset_in_id');
    }
}
