<?php

namespace App\Filament\Resources\BirthResource\Pages;

use App\Filament\Resources\BirthResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBirths extends ManageRecords
{
    protected static string $resource = BirthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
