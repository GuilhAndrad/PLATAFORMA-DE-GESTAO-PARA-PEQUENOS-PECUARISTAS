<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeathResource\Pages;
use App\Filament\Resources\DeathResource\RelationManagers;
use App\Models\Death;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeathResource extends Resource
{
    protected static ?string $model = Death::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-minus';

    protected static ?string $navigationGroup = 'Gestão de Animais';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('farm_id')
                    ->label('Fazenda')
                    ->options(\App\Models\Farm::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('animal_quantity')
                    ->label('Quantidade de Animais Mortos')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('cause')->label('Causa da Morte')->required(),
                Forms\Components\DatePicker::make('death_date')->label('Data da Morte')->default(now())->required(),
                Forms\Components\Textarea::make('notes')->label('Observações'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('farm.name')->label('Fazenda'),
            Tables\Columns\TextColumn::make('animal_quantity')->label('Quantidade de Animais'),
            Tables\Columns\TextColumn::make('cause')->label('Causa da Morte'),
            Tables\Columns\TextColumn::make('death_date')->label('Data da Morte')->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDeaths::route('/'),
        ];
    }
}
