<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubContractInItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_contract_in_id',
        'item_code',
        'quantity',
        'waste',
        'soc_number',
        'production_planning_number',
        'order_number',
        'product_code',
        'customs_document_code',
        'registration_number',
        'customs_document_number',
        'customs_document_date',
        'notes',
    ];

    public function subContractIn()
    {
        return $this->belongsTo(SubContractIn::class, 'sub_contract_in_id');
    }
}
