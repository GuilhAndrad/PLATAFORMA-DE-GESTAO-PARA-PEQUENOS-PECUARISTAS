<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'buyer',
        'animal_quantity',
        'weight_per_animal',
        'purchase_date',
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
        static::creating(function (Purchase $purchase) {
            $purchase->farm->increment('animal_quantity', $purchase->animal_quantity);
        });
    }

    public function cancel()
    {
        if (!$this->is_canceled) {
            // Reverte a quantidade de animais na fazenda
            $this->farm->decrement('animal_quantity', $this->animal_quantity);

            // Marca a transação como cancelada e como não paga
            $this->is_canceled = true;
            $this->is_paid = false;
            $this->save();
        }
    }
}