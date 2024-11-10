<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'buyer',
        'animal_quantity',
        'weight_per_animal',
        'sale_date',
        'price',
        'is_paid',
        'is_canceled',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    protected static function booted()
    {
        static::creating(function (Sale $sale) {
            $sale->farm->decrement('animal_quantity', $sale->animal_quantity);
        });
    }

    public function cancel()
    {
        if (!$this->is_canceled) {
            // Reverte a quantidade de animais na fazenda
            $this->farm->increment('animal_quantity', $this->animal_quantity);

            // Marca a transação como cancelada e como não paga
            $this->is_canceled = true;
            $this->is_paid = false;
            $this->save();
        }
    }

}
