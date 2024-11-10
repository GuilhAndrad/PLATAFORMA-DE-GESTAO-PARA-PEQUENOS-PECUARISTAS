<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransferResource\Pages;
use App\Filament\Resources\TransferResource\RelationManagers;
use App\Models\Transfer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransferResource extends Resource
{
    protected static ?string $model = Transfer::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $navigationGroup = 'Gestão de Animais';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('origin_farm_id')
                ->label('Fazenda de Origem')
                ->options(\App\Models\Farm::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(fn (callable $set, $state) => $set('available_animals', \App\Models\Farm::find($state)?->animal_quantity ?? 0)),

            Forms\Components\TextInput::make('available_animals')
                ->label('Animais Disponíveis')
                ->disabled()
                ->reactive(),

            Forms\Components\Select::make('destination_farm_id')
                ->label('Fazenda de Destino')
                ->options(\App\Models\Farm::pluck('name', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('animal_quantity')
                ->label('Quantidade de Animais')
                ->required()
                ->numeric()
                ->minValue(1)
                ->placeholder('Quantidade de animais a transferir'),

            Forms\Components\DatePicker::make('transfer_date')
                ->label('Data da Transferência')
                ->default(now())
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('originFarm.name')
                ->label('Fazenda de Origem')
                ->searchable()
                ->limit(20),

            Tables\Columns\TextColumn::make('destinationFarm.name')
                ->label('Fazenda de Destino')
                ->searchable()
                ->limit(20),

            Tables\Columns\TextColumn::make('animal_quantity')
                ->label('Qtd. de Animais')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('transfer_date')
                ->label('Data')
                ->date()
                ->alignCenter(),
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
            'index' => Pages\ManageTransfers::route('/'),
        ];
    }
}
