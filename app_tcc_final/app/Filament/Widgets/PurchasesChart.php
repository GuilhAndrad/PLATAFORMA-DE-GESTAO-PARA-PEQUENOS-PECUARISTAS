<?php

namespace App\Filament\Widgets;

use App\Models\Purchase;
use Filament\Widgets\ChartWidget;

class PurchasesChart extends ChartWidget
{
    protected static ?string $heading = 'Compras Mensais';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        /*$monthlyPurchases = Purchase::selectRaw('MONTH(purchase_date) as month, SUM(animal_quantity) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');*/
            $monthlyPurchases = Purchase::selectRaw('strftime("%m", purchase_date) as month, SUM(animal_quantity) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');


        return [
            'datasets' => [
                [
                    'label' => 'Compras',
                    'data' => $monthlyPurchases->values(),
                    'backgroundColor' => '#4299E1',
                ],
            ],
            'labels' => $monthlyPurchases->keys()->map(fn($month) => date('F', mktime(0, 0, 0, $month, 10))),
        ];
    }
}
