<?php

namespace App\Filament\Resources\RentalsResource\Pages;

use App\Filament\Resources\RentalsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRentals extends ManageRecords
{
    protected static string $resource = RentalsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
