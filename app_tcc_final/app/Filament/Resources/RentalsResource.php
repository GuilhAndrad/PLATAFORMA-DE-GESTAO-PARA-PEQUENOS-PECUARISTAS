<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalsResource\Pages;
use App\Models\Rentals;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RentalsResource extends Resource
{
    protected static ?string $model = Rentals::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Gestão de Animais';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('farm_id')
                ->label('Fazenda')
                ->options(\App\Models\Farm::all()->pluck('name', 'id')) // Carrega nomes e IDs das fazendas
                ->searchable() // Torna o campo de busca disponível
                ->required(),
            Forms\Components\TextInput::make('animal_quantity')
                ->label('Quantidade')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('price_per_head')
                ->label('Preço por Cabeça')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('location')
                ->label('Localização')
                ->required(),
            Forms\Components\TextInput::make('rental_duration_days')
                ->label('Duração (dias)')
                ->required()
                ->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
         ->defaultSort('returned', 'asc')
            ->filtersTriggerAction(fn(Tables\Actions\Action $action)=>
                $action ->icon('heroicon-s-adjustments-vertical')
                ->slideOver())
                ->columns([
                    TextColumn::make('farm.name')
                        ->label('Fazenda')
                        ->limit(20)
                        ->searchable() // Limita o tamanho visível do texto
                        ->tooltip(fn ($record) => $record->farm->name), // Tooltip com o nome completo
                    TextColumn::make('animal_quantity')
                        ->label('Quantidade')
                        ->visibleFrom('md')
                        ->limit(10), // Limita o tamanho visível do texto
                    TextColumn::make('price_per_head')
                        ->label('Preço por Cabeça')
                        ->visibleFrom('md')
                        ->limit(10), // Limita o tamanho visível do texto
                    TextColumn::make('location')
                        ->label('Localização')
                        ->visibleFrom('md')
                        ->limit(20), // Limita o tamanho visível do texto
                    TextColumn::make('rental_duration_days')
                        ->label('Duração (dias)')
                        ->visibleFrom('md'),
                    TextColumn::make('total_cost')
                        ->label('Custo Total')
                        ->visibleFrom('md'),
                    BooleanColumn::make('returned')
                        ->label('Devolvido'),
                ])

            ->recordClasses(fn ($record) => $record->returned ? 'opacity-50 bg-gray-200 dark:bg-gray-800' : '')

            ->actions([
                Tables\Actions\EditAction::make()
                    //->hidden(fn ($record) => $record->returned)
                    ->label('Editar')
                    ->icon('heroicon-o-pencil')
                    ->color('primary'), // Define a cor do botão
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn ($record) => $record->returned)
                    ->label('Excluir')
                    ->icon('heroicon-o-trash')
                    ->color('danger'), // Define a cor do botão

                ActionsAction::make('returnAnimals')
                    ->label('Retornar')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->action(function (Rentals $record) {
                        $record->returnAnimals();
                        Notification::make()
                            ->title('Animais retornados com sucesso!')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->hidden(fn ($record) => $record->returned),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                // Adiciona um filtro para o status de devolução
                Tables\Filters\SelectFilter::make('returned')
                    ->label('Devolução')
                    ->options([
                        true => 'Devolvidos',
                        false => 'Não Devolvidos',
                    ])
                    ->placeholder('Todos'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRentals::route('/'),
        ];
    }
}
