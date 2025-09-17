<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'reject_id',
        'item_code',
        'quantity',
        'request_number',
        'soc_number',
        'planning_number',
        'order_number',
        'product_code',
        'notes',
    ];

    public function reject()
    {
        return $this->belongsTo(Reject::class, 'reject_id');
    }
}
