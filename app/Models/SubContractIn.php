<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubContractIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_contract_in_number',
        'sub_contract_in_date',
        'subcontractor_entity_code',
        'sub_contract_out',
        'license_number',
        'license_date',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(SubContractInItem::class, 'sub_contract_in_id');
    }
}
