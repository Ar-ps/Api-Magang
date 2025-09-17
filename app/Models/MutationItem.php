<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'mutation_id',
        'item_code',
        'quantity',
        'request_number',
        'soc_number',
        'planning_number',
        'order_number',
        'product_code',
        'notes',
    ];

    public function mutation()
    {
        return $this->belongsTo(Mutation::class, 'mutation_id');
    }
}
