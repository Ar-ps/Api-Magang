<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    protected $fillable = [
        'api_id',
        'revision',
        'soc_number',
        'bill_of_material_date',
        'bill_of_material_number',
        'finished_goods_item_code',
    ];

    public function details()
    {
        return $this->hasMany(BomDetailItem::class);
    }
}
