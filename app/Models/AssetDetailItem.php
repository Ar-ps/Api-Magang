<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetDetailItem extends Model
{
    protected $fillable = [
        'api_id',
        'asset_id',
        'notes',
        'quantity',
        'item_code',
        'unit_price',
        'total_price',
        'customs_code',
        'invoice_date',
        'invoice_number',
        'asset_order_number',
        'registration_number',
        'customs_document_date',
        'customs_document_number',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
