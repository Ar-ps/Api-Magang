<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'planning_production_number',
        'planning_production_date',
        'start_date',
        'finish_date',
        'planning_status',
        'entry_date',
        'closer_id',
        'closing_date',
    ];

    public function items()
    {
        return $this->hasMany(ProductionPlanItem::class);
    }
}
