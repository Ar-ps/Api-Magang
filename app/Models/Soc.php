<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soc extends Model
{
    use HasFactory;

    protected $fillable = [
        'soc_number',
        'soc_date',
        'entity_code',
        'currency_code',
        'delivery_date',
        'description',
        'crm_number',
        'entry_date',
    ];

    public function items()
    {
        return $this->hasMany(SocItem::class, 'soc_id'); // tambahkan foreign key
    }
}
