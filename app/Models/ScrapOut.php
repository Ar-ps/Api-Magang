<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapOut extends Model
{
    use HasFactory;

    protected $table = 'scrap_outs';

    protected $fillable = [
        'scrap_out_number',
        'scrap_out_date',
        'decree_number',
        'decree_date',
        'location',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(ScrapOutItem::class, 'scrap_out_id');
    }
}
