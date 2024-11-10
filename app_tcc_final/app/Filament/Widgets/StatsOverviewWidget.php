<?php

namespace App\Filament\Widgets;

use App\Models\Birth;
use App\Models\Death;
use App\Models\Farm;
use App\Models\Transfer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        return [
            Stat::make('Total de Animais', Farm::sum('animal_quantity'))
                ->description('Atualizado diariamente')
                ->color('success'),
            Stat::make('Nascimentos', Birth::sum('animal_quantity'))
                ->description('Este mês')
                ->color('success'),
            Stat::make('Mortes', Death::sum('animal_quantity'))
                ->description('Este mês')
                ->color('danger'),
            Stat::make('Transferências', Transfer::count())
                ->description('Realizadas este mês')
                ->color('primary'),
        ];
    }
}
