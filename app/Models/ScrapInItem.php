<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapInItem extends Model
{
    use HasFactory;

    protected $table = 'scrap_in_items';

    protected $fillable = [
        'scrap_in_id',
        'item_code',
        'quantity',
        'production_process_number',
        'notes',
    ];

    public function scrapIn()
    {
        return $this->belongsTo(ScrapIn::class, 'scrap_in_id');
    }
}
