<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapOutItem extends Model
{
    use HasFactory;

    protected $table = 'scrap_out_items';

    protected $fillable = [
        'scrap_out_id',
        'item_code',
        'quantity',
        'production_process_number',
        'notes',
    ];

    public function scrapOut()
    {
        return $this->belongsTo(ScrapOut::class, 'scrap_out_id');
    }
}
