<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_process_id',
        'process_document_number',
        'production_team_id',
        'production_building_id',
        'production_line_id',
        'production_start_date',
        'production_end_date',
        'entry_date',
        'confirmation_status',
        'confirmation_date',
        'confirmation_id',
    ];
    protected $primaryKey = 'production_process_id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function inputs()
    {
        return $this->hasMany(ProductionInput::class, 'production_process_id');
    }

    public function outputs()
    {
        return $this->hasMany(ProductionOutputProcess::class, 'production_process_id');
    }
}
