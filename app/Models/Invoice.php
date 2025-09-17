<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'cosignee_entity_code',
        'notify_party',
        'soc_number',
        'currency_code',
        'terms_of_payment',
        'incoterms',
        'loading_port',
        'unloading_port',
        'country_origin_code',
        'bl_awb_number',
        'freight',
        'insurance',
        'shipping_marks',
        'remarks',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }
}
