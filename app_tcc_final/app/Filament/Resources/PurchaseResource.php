<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Purchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
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
                ->reactive()
                ->afterStateUpdated(fn (callable $set, $state) => $set('available_animals', \App\Models\Farm::find($state)?->animal_quantity ?? 0)),

            Forms\Components\TextInput::make('available_animals')
                ->label('Animais Disponíveis')
                ->disabled()
                ->reactive(),

            Forms\Components\TextInput::make('buyer')
                ->label('Comprador')
                ->required()
                ->maxLength(100)
                ->placeholder('Nome do comprador'),

            Forms\Components\TextInput::make('animal_quantity')
                ->label('Quantidade de Animais')
                ->required()
                ->numeric()
                ->minValue(1)
                ->placeholder('Ex.: 10'),

            Forms\Components\TextInput::make('weight_per_animal')
                ->label('Peso por Animal (kg)')
                ->required()
                ->numeric()
                ->minValue(0.1)
                ->placeholder('Ex.: 250'),

            Forms\Components\DatePicker::make('purchase_date')
                ->label('Data da Compra')
                ->default(now())
                ->required(),

            Forms\Components\TextInput::make('price')
                ->label('Valor da Compra')
                ->required()
                ->numeric(),

            Forms\Components\Toggle::make('is_paid')
                ->label('Pago'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('farm.name')
                ->label('Fazenda')
                ->limit(20),

            Tables\Columns\TextColumn::make('buyer')
                ->label('Comprador')
                ->limit(15)
                ->visibleFrom('md'),
            Tables\Columns\TextColumn::make('animal_quantity')
                ->label('Qtd. de Animais')
                ->alignCenter()
                ->sortable(),

            Tables\Columns\TextColumn::make('purchase_date')
                ->label('Data da Compra')
                ->date()
                ->alignCenter(),

            Tables\Columns\TextColumn::make('price')
                ->label('Valor da Compra')
                ->date()
                ->alignCenter(),

            Tables\Columns\BooleanColumn::make('is_paid')
                ->label('Pago')
                ->alignCenter(),

            Tables\Columns\BooleanColumn::make('is_canceled')
                ->label('Cancelado')
                ->visible(fn ($record) => $record && $record->is_canceled),
        ])
        ->recordClasses(fn ($record) => $record && $record->is_canceled ? 'opacity-50 bg-gray-200 dark:bg-gray-800' : '')
            ->filters([
                //
            ])
            ->actions([
                Action::make('cancel')
                ->label('Cancelar Compra')
                ->action(function (Purchase $record) {
                    if ($record) {
                        $record->cancel();
                        Notification::make()
                            ->title('Compra cancelada com sucesso!')
                            ->success()
                            ->send();
                    }
                })
                ->requiresConfirmation()
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->hidden(fn ($record) => $record->is_canceled),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                ->hidden(fn ($record) => $record->is_canceled),
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
            'index' => Pages\ManagePurchases::route('/'),
        ];
    }
}
