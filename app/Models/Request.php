<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_document_number',
        'request_date',
        'needed_date',
        'department_id',
        'entry_date',
        'received_status',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(RequestItem::class, 'request_id');
    }
}
