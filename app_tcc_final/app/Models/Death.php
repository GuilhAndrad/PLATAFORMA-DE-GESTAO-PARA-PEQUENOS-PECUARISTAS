<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Death extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'death_date',
        'animal_quantity',
        'cause',
        'notes',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    protected static function booted()
    {
        static::creating(function (Death $death) {
            $death->farm->decrement('animal_quantity', $death->animal_quantity);
        });
    }
}
