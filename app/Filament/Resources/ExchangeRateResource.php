<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExchangeRateResource\Pages;
use App\Filament\Resources\ExchangeRateResource\RelationManagers;
use App\Models\ExchangeRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class ExchangeRateResource extends Resource
{
    protected static ?string $model = ExchangeRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    // protected string $maxContentWidth = MaxWidth::Medium;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(10)

                    ->disabled(fn(string $operation): bool => $operation === 'edit'),
                // ->mutateStateForValidation(fn(string $state): string => strtoupper($state)),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('buying_rate')
                    ->required()
                    ->numeric()
                    ->columnSpan(2),
                // ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)->prefix('Rp'),
                Forms\Components\TextInput::make('selling_rate')
                    ->required()
                    ->numeric()
                    ->columnSpan(2)
            ])->columns(2)

        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('buying_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('selling_rate')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExchangeRates::route('/'),
            'create' => Pages\CreateExchangeRate::route('/create'),
            'edit' => Pages\EditExchangeRate::route('/{record}/edit'),
        ];
    }
}
