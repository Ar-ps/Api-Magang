<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapIn extends Model
{
    use HasFactory;

    protected $table = 'scrap_ins';

    protected $fillable = [
        'scrap_in_number',
        'scrap_in_date',
        'scrap_code',
        'quantity',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(ScrapInItem::class, 'scrap_in_id');
    }
}
