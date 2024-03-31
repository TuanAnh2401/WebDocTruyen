<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtVip extends Model
{
    use HasFactory;

    protected $table = 'ct_vips';

    protected $fillable = [
        'price_id',
        'user_id',
        'price',
        'end_date',
        'is_deleted',
    ];
}

