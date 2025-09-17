<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'internal_asset_number',
        'internal_asset_date',
        'department_id',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];

    public function items()
    {
        return $this->hasMany(InternalAssetItem::class, 'internal_asset_id');
    }
}
