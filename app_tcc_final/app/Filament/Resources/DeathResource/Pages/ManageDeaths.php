<?php

namespace App\Filament\Resources\DeathResource\Pages;

use App\Filament\Resources\DeathResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDeaths extends ManageRecords
{
    protected static string $resource = DeathResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
