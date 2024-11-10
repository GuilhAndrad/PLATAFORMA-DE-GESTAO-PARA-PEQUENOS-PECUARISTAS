<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BirthResource\Pages;
use App\Filament\Resources\BirthResource\RelationManagers;
use App\Models\Birth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BirthResource extends Resource
{
    protected static ?string $model = Birth::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

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
                ->label('Quantidade de Animais Nascidos')
                ->required()
                ->numeric(),
            Forms\Components\Select::make('gender')
                ->label('Sexo dos Animais')
                ->options([
                    'male' => 'Macho',
                    'female' => 'Fêmea',
                ])
                ->required(),
            Forms\Components\DatePicker::make('birth_date')->label('Data do Nascimento')->default(now())->required(),
            Forms\Components\Textarea::make('notes')->label('Observações'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('farm.name')->label('Fazenda'),
            Tables\Columns\TextColumn::make('animal_quantity')->label('Quantidade de Animais'),
            Tables\Columns\TextColumn::make('gender')->label('Sexo'),
            Tables\Columns\TextColumn::make('birth_date')->label('Data do Nascimento')->date()
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
            'index' => Pages\ManageBirths::route('/'),
        ];
    }
}
