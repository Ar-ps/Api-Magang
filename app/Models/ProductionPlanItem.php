<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_plan_id',
        'finished_goods_item_code',
        'planning_quantity',
        'finished_quantity',
        'bill_of_material_number',
        'soc_number',
    ];

    public function plan()
    {
        return $this->belongsTo(ProductionPlan::class, 'production_plan_id');
    }
}
