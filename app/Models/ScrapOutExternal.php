<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapOutExternal extends Model
{
    use HasFactory;

    protected $table = 'scrap_out_externals';

    protected $fillable = [
        'scrap_out_external_number',
        'scrap_out_external_date',
        'transaction_type',
        'receiver_entity_code',
        'currency_code',
        'decree_number',
        'decree_date',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(ScrapOutExternalItem::class, 'scrap_out_external_id');
    }
}
