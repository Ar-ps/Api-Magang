<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bom_id',
        'raw_material_item_code',
        'scrap',
        'quantity',
        'consumption',
        'soc_number',
        'notes',
    ];

    public function bom()
    {
        return $this->belongsTo(Bom::class);
    }
}
