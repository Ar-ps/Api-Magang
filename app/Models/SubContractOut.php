<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubContractOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_contract_out_number',
        'sub_contract_out_date',
        'subcontractor_entity_code',
        'work_to_do',
        'license_number',
        'license_date',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(SubContractOutItem::class, 'sub_contract_out_id');
    }
}
