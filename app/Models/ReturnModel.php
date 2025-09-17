<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnModel extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'return_number',
        'return_date',
        'receiver_entity_code',
        'entry_date',
        'return_status',
        'status_date',
        'approver',
    ];

    public function items()
    {
        return $this->hasMany(ReturnItem::class, 'return_id');
    }
}
