<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapOutExternalItem extends Model
{
    use HasFactory;

    protected $table = 'scrap_out_external_items';

    protected $fillable = [
        'scrap_out_external_id',
        'item_code',
        'item_quantity',
        'item_unit_price',
        'item_total_price',
        'reference_number',
        'notes',
    ];

    public function scrapOutExternal()
    {
        return $this->belongsTo(ScrapOutExternal::class, 'scrap_out_external_id');
    }
}
