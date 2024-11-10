<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'Gestão de Transações';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('farm_id')
                ->label('Fazenda')
                ->options(\App\Models\Farm::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->reactive(),

            Forms\Components\TextInput::make('item')
                ->label('Item')
                ->placeholder('Ex: Remédio, Sal, Ração')
                ->required()
                ->maxLength(100),

            Forms\Components\TextInput::make('cost')
                ->label('Custo Total')
                ->numeric()
                ->required()
                ->minValue(0.01)
                ->placeholder('Ex.: 100.00'),

            Forms\Components\TextInput::make('quantity')
                ->label('Quantidade')
                ->numeric()
                ->nullable(),

            Forms\Components\DatePicker::make('expense_date')
                ->label('Data da Despesa')
                ->default(now())
                ->required(),

            Forms\Components\Textarea::make('notes')
                ->label('Observações')
                ->maxLength(250)
                ->placeholder('Informações adicionais sobre a despesa (opcional)'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('farm.name')
                ->searchable()
                ->label('Fazenda')
                ->limit(20),

            Tables\Columns\TextColumn::make('item')
                ->searchable()
                ->label('Item')
                ->limit(15),

            Tables\Columns\TextColumn::make('cost')
                ->label('Custo Total')
                ->money('BRL')
                ->sortable(),

            Tables\Columns\TextColumn::make('quantity')
                ->label('Quantidade')
                ->alignCenter(),

            Tables\Columns\TextColumn::make('expense_date')
                ->label('Data da Despesa')
                ->date()
                ->alignCenter(),

            Tables\Columns\TextColumn::make('notes')
                ->label('Observações')
                ->limit(30),
        ])
        ->recordClasses(fn ($record) => $record && $record->is_canceled ? 'opacity-50 bg-gray-200 dark:bg-gray-800' : '')
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
                //->hidden(fn ($record) => $record->is_canceled),

            Tables\Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->hidden(fn ($record) => $record->is_canceled)
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
            'index' => Pages\ManageExpenses::route('/'),
        ];
    }
}
