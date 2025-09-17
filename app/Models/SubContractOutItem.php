<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubContractOutItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_contract_out_id',
        'item_code',
        'quantity',
        'soc_number',
        'production_planning_number',
        'order_document_number',
        'product_code',
        'notes',
    ];

    public function subContractOut()
    {
        return $this->belongsTo(SubContractOut::class, 'sub_contract_out_id');
    }
}
