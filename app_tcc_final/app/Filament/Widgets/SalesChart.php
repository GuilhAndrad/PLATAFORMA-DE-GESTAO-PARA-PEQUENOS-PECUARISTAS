<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Vendas Mensais';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        /*$monthlySales = Sale::selectRaw('MONTH(sale_date) as month, SUM(animal_quantity) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
        */

        $monthlySales = Sale::selectRaw('strftime("%m", sale_date) as month, SUM(animal_quantity) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        return [
            'datasets' => [
                [
                    'label' => 'Vendas',
                    'data' => $monthlySales->values(),
                    'backgroundColor' => '#FC8181',
                ],
            ],
            'labels' => $monthlySales->keys()->map(fn($month) => date('F', mktime(0, 0, 0, $month, 10))),
        ];
    }
}
