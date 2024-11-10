<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BirthEnum: string implements HasLabel
{
    case MALE =  'male';
    case FEMALE = 'female';

    public function getLabel(): ?string
    {
        return match ($this){
            self::MALE => 'Macho',
            self::FEMALE => 'Fêmea',
        };
    }
}