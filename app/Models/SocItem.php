<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'soc_id',
        'soc_number',
        'item_code',
        'quantity',
        'unit_price',
    ];

    public function soc()
    {
        return $this->belongsTo(Soc::class, 'soc_id'); // pastikan pakai soc_id
    }
}
