<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $table = 'item_categories';

    protected $fillable = [
        'item_category_code',
        'item_category_name',
        'item_group_code',
        'noakhir',
    ];
}
