<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FarmTypeEnum: string implements HasLabel
{
    case HEADQUARTERS =  'headquarters';
    case RENTED = 'rented';

    public function getLabel(): ?string
    {
        return match ($this){
            self::HEADQUARTERS => 'Sede',
            self::RENTED => 'Aluguel'
        };
    }
}