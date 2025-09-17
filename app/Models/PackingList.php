<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'packing_list_number',
        'packing_list_date',
        'invoice_number',
        'invoice_date',
        'cosignee_entity_code',
        'notify_party',
        'soc_number',
        'currency_code',
        'terms_of_payment',
        'incoterms',
        'country_origin_code',
        'loading_port',
        'unloading_port',
        'bl_awb_number',
        'remarks',
        'entry_date',
    ];

    public function items()
    {
        return $this->hasMany(PackingListItem::class, 'packing_list_id', 'id');
    }
}
