<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JualResource\Pages;
use App\Filament\Resources\JualResource\RelationManagers;
use App\Models\Jual;
// use App\Models\Buying;
use App\Models\Country;
use App\Models\Customer;
use App\Models\ExchangeRate;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
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


class JualResource extends Resource
{
    protected static ?string $model = Jual::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Input Penjualan';

    protected static ?string $navigationGroup = 'TransaksiPenjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Header')
                    ->schema([

                        Grid::make(3)
                            ->schema([

                                TextInput::make('bill_no')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->validationMessages([
                                        'unique' => 'Nomor Bukti Sudah Ada.',
                                    ])
                                    ->readOnly(fn($operation) => $operation === 'edit')
                                    ->label('Nomor Bukti'),


                                // ->label('No Bukti')
                                // ->required()
                                // ->unique(),

                                DatePicker::make('date')
                                    ->default(now())
                                    ->required(),

                                TimePicker::make('time')
                                    ->seconds(false)
                                    ->default(now())
                                    ->required(),
                            ]),

                        Select::make('customer_id')
                            ->options(
                                Customer::pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {

                                $customer = Customer::find($state);

                                if ($customer) {

                                    $set('customer_name', $customer->name);
                                    $set('customer_phone', $customer->phone);
                                }
                            }),



                        Grid::make(2)
                            ->schema([

                                TextInput::make('customer_name')
                                    ->disabled()->dehydrated(true),

                                TextInput::make('customer_phone')
                                    ->disabled()->dehydrated(true),
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
                                    ->disabled()->dehydrated(true),

                                TextInput::make('country_name')
                                    ->disabled()->dehydrated(true),
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
                                                        'selling_rate',
                                                        $rate->selling_rate
                                                    );
                                                }
                                            })
                                            ->required(),

                                        Hidden::make('currency_code'),

                                        TextInput::make('nominal')
                                            ->numeric()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Get $get, Set $set) {

                                                $subtotal =
                                                    (float)$get('nominal') *
                                                    (float)$get('selling_rate');

                                                $set('subtotal', $subtotal);
                                            })
                                            ->required(),

                                        TextInput::make('selling_rate')
                                            ->numeric()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Get $get, Set $set) {

                                                $subtotal =
                                                    (float)$get('nominal') *
                                                    (float)$get('selling_rate');

                                                $set('subtotal', $subtotal);
                                            })
                                            ->required(),

                                        TextInput::make('subtotal')
                                            ->numeric()
                                            ->readOnly(),
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
                Tables\Columns\TextColumn::make('bill_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),
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
            'index' => Pages\ListJuals::route('/'),
            'create' => Pages\CreateJual::route('/create'),
            'edit' => Pages\EditJual::route('/{record}/edit'),
        ];
    }
}
