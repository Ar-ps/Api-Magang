<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionOutputItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_output_id',
        'item_code',
        'quantity',
        'pass_quantity',
        'reject_quantity',
        'reject_reason',
        'soc_number',
        'production_planning_number',
        'note',
    ];

    public function productionOutput()
    {
        return $this->belongsTo(ProductionOutput::class, 'production_output_id', 'id');
    }
}
