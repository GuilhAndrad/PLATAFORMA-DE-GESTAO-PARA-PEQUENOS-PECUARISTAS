<?php

namespace App\Models;

use App\Enums\FarmTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'owner',
        'location',
        'type',
        'animal_quantity',
        'status',
    ];

    protected $casts = [
        'type' => FarmTypeEnum::class,
        'status' => 'boolean',
    ];
}
