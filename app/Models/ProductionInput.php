<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionInput extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_process_id',
        'item_code',
        'quantity',
        'waste',
        'usage',
        'soc_number',
        'production_planning_number',
        'order_number',
        'product_code',
        'notes',
    ];

    public function process()
    {
        return $this->belongsTo(ProductionProcess::class, 'production_process_id');
    }
}
