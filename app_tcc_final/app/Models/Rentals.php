<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentals extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'animal_quantity',
        'price_per_head',
        'location',
        'rental_duration_days',
        'returned',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    // Método acessor para calcular o custo total do aluguel
    public function getTotalCostAttribute(): float
    {
        return $this->animal_quantity * $this->price_per_head * ($this->rental_duration_days / 30);
    }
    // Método boot com o evento creating para ajustar quantidade de animais
    public static function boot()
    {
        parent::boot();

        // Evento para reduzir animais da fazenda ao criar um aluguel
        static::creating(function (Rentals $rental) {
            $rental->rentAnimals(); // Reduz os animais da fazenda
        });
    }

    // Método para reduzir animais ao alugar
    public function rentAnimals()
    {
        $farm = $this->farm;

        // Verifica se há animais suficientes para alugar
        if ($farm->animal_quantity >= $this->animal_quantity) {
            $farm->animal_quantity -= $this->animal_quantity;
            $farm->save();
        } else {
            throw new \Exception('Não há animais suficientes na fazenda para alugar.');
        }
    }

    // Método para devolver animais
    public function returnAnimals()
    {
        if (!$this->returned) {
            $this->returned = true;
            $this->save();

            // Adiciona os animais de volta à fazenda
            $farm = $this->farm;
            $farm->animal_quantity += $this->animal_quantity;
            $farm->save();
        }
    }
}