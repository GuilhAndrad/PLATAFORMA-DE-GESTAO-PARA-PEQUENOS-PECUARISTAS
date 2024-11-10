<?php

namespace App\Models;

use App\Enums\BirthEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Birth extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'birth_date',
        'animal_quantity',
        'gender',
        'notes',
    ];

    protected $casts = [
        'gender' => BirthEnum::class,
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    protected static function booted()
    {
        static::creating(function (Birth $birth) {
            $birth->farm->increment('animal_quantity', $birth->animal_quantity);
        });
    }
}
