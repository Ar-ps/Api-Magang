<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'packing_list_id',
        'marks',
        'item_code',
        'item_name',
        'unit_code',
        'quantity',
        'nett_weight',
        'gross_weight',
        'measurement',
        'cbm',
        'packing_type',
        'remarks',
    ];

    public function packingList()
    {
        return $this->belongsTo(PackingList::class, 'packing_list_id', 'id');
    }
}
