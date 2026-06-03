<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BuyingResource\Pages;
use App\Filament\Resources\BuyingResource\RelationManagers;
use App\Models\Buying;
use App\Models\Country;
use App\Models\ExchangeRate;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BuyingResource extends Resource
{
    protected static ?string $model = Buying::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Header')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                TextInput::make('bill_no')
                                    ->label('No Bukti')
                                    ->required(),

                                DatePicker::make('date')
                                    ->default(now())
                                    ->required(),

                                TimePicker::make('time')
                                    ->seconds(false)
                                    ->default(now())
                                    ->required(),
                            ]),

                        Grid::make(2)
                            ->schema([

                                TextInput::make('customer_name')
                                    ->required(),

                                TextInput::make('customer_phone'),
                            ]),

                        Select::make('country_id')
                            ->options(
                                Country::pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {

                                $country = Country::find($state);

                                if ($country) {

                                    $set('country_code', $country->code);
                                    $set('country_name', $country->name);
                                }
                            }),

                        Grid::make(2)
                            ->schema([

                                TextInput::make('country_code')
                                    ->disabled(),

                                TextInput::make('country_name')
                                    ->disabled(),
                            ]),
                    ]),

                Section::make('Detail Valas')
                    ->schema([

                        Repeater::make('items')
                            ->relationship()
                            ->schema([

                                Grid::make(4)
                                    ->schema([

                                        Select::make('exchange_rate_id')
                                            ->label('Currency')
                                            ->options(
                                                ExchangeRate::pluck('code', 'id')
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->live()
                                            ->afterStateUpdated(function ($state, Set $set) {

                                                $rate = ExchangeRate::find($state);

                                                if ($rate) {

                                                    $set('currency_code', $rate->code);

                                                    $set(
                                                        'buying_rate',
                                                        $rate->buying_rate
                                                    );
                                                }
                                            })
                                            ->required(),

                                        TextInput::make('nominal')
                                            ->numeric()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Get $get, Set $set) {

                                                $subtotal =
                                                    (float)$get('nominal') *
                                                    (float)$get('buying_rate');

                                                $set('subtotal', $subtotal);
                                            })
                                            ->required(),

                                        TextInput::make('buying_rate')
                                            ->numeric()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Get $get, Set $set) {

                                                $subtotal =
                                                    (float)$get('nominal') *
                                                    (float)$get('buying_rate');

                                                $set('subtotal', $subtotal);
                                            })
                                            ->required(),

                                        TextInput::make('subtotal')
                                            ->numeric()
                                            ->disabled(),
                                    ]),

                                TextInput::make('currency_code')
                                    ->hidden(),
                            ])
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {

                                $items = $get('items');

                                $total = collect($items)
                                    ->sum(fn($item) => (float)($item['subtotal'] ?? 0));

                                $set('total', $total);
                            })
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Valas')
                            ->columnSpanFull(),
                    ]),

                Section::make('Total')
                    ->schema([

                        TextInput::make('total')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListBuyings::route('/'),
            'create' => Pages\CreateBuying::route('/create'),
            'edit' => Pages\EditBuying::route('/{record}/edit'),
        ];
    }
}
