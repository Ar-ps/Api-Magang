<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetInItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_in_id',
        'item_code',
        'quantity',
        'unit_price',
        'total_price',
        'asset_order_number',
        'invoice_number',
        'invoice_date',
        'customs_code',
        'registration_number',
        'customs_document_number',
        'customs_document_date',
        'notes',
    ];

    public function assetIn()
    {
        return $this->belongsTo(AssetIn::class, 'asset_in_id');
    }
}
