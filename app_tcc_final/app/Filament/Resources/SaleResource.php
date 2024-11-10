<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
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
                ->disabled() // Campo somente para exibição, sem edição
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
                ->placeholder('Ex.: 10')
                ->reactive()
                ->afterStateUpdated(fn (callable $get, callable $set, $state) => $set('is_valid_quantity', $state <= $get('available_animals'))),

            Forms\Components\TextInput::make('weight_per_animal')
                ->label('Peso por Animal (kg)')
                ->required()
                ->numeric()
                ->minValue(0.1)
                ->placeholder('Ex.: 250'),

            Forms\Components\DatePicker::make('sale_date')
                ->label('Data da Venda')
                ->default(now())
                ->required(),

            Forms\Components\TextInput::make('price')
                ->label('Valor da Venda')
                ->required()
                ->numeric(),

            Forms\Components\Toggle::make('is_paid')
                ->label('Pago'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->defaultSort('is_paid', 'asc')
        ->columns([
            Tables\Columns\TextColumn::make('farm.name')
                ->label('Fazenda')
                ->searchable()
                ->limit(20),

            Tables\Columns\TextColumn::make('buyer')
                ->label('Comprador')
                ->searchable()
                ->limit(15)
                ->visibleFrom('md'),

            Tables\Columns\TextColumn::make('animal_quantity')
                ->label('Qtd. de Animais')
                ->alignCenter()
                ->sortable(),

            Tables\Columns\TextColumn::make('sale_date')
                ->label('Data')
                ->date()
                ->alignCenter(),

            Tables\Columns\TextColumn::make('price')
                ->label('Valor da Venda')
                ->date()
                ->alignCenter(),

            Tables\Columns\BooleanColumn::make('is_paid')
                ->label('Pago')
                ->alignCenter(),

            Tables\Columns\BooleanColumn::make('is_canceled')
                ->label('Cancelado')
                ->hidden(fn ($record) => !$record || !$record->is_canceled),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Editar Venda')
                    ->modalButton('Confirmar Edição'),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Excluir Venda')
                    ->modalButton('Confirmar Exclusão'),

                Action::make('cancel')
                    ->label('Cancelar Venda')
                    ->action(function (Sale $record) {
                        $record->cancel();
                        Notification::make()
                            ->title('Venda cancelada com sucesso!')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-shield-exclamation')
                    ->hidden(fn (Sale $record) => $record->is_canceled),
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
            'index' => Pages\ManageSales::route('/'),
        ];
    }
}
