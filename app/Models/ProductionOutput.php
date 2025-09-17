<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionOutput extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_output_number',
        'production_output_date',
        'production_team',
        'production_building',
        'production_line',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(ProductionOutputItem::class, 'production_output_id', 'id');
    }
}
