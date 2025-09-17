<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reject extends Model
{
    use HasFactory;

    protected $fillable = [
        'mutation_number',
        'mutation_date',
        'department_id',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
    ];

    public function items()
    {
        return $this->hasMany(RejectItem::class, 'reject_id');
    }
}
