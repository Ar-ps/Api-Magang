<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'customs_document_code',
        'customs_document_number',
        'customs_document_date',
        'receiver_code',
        'currency_code',
        'payment_type',
        'bl_awb_number',
        'bl_awb_date',
        'license_number',
        'license_date',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(CustomInItem::class, 'custom_in_id');
    }
}
