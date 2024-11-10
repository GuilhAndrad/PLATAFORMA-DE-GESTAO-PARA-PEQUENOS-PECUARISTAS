<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_farm_id',
        'destination_farm_id',
        'animal_quantity',
        'transfer_date',
    ];

    public function originFarm()
    {
        return $this->belongsTo(Farm::class, 'origin_farm_id');
    }

    public function destinationFarm()
    {
        return $this->belongsTo(Farm::class, 'destination_farm_id');
    }

    protected static function booted()
    {
        static::creating(function (Transfer $transfer) {
            $transfer->executeTransfer();
        });
    }

    public function executeTransfer()
    {
        // Reduz os animais da fazenda de origem
        $this->originFarm->decrement('animal_quantity', $this->animal_quantity);

        // Adiciona os animais à fazenda de destino
        $this->destinationFarm->increment('animal_quantity', $this->animal_quantity);

        // Não é necessário chamar $this->save() aqui
    }
}
