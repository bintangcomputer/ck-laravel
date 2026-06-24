<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('country_id')
                //     ->required()
                //     ->numeric(),
                Forms\Components\Select::make('country_id')
                    ->relationship('country', 'code')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                    ->searchable(['code', 'name'])
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('identity_number')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Textarea::make('adress')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('occupation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('identity_expired_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('country_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('country.name')
                //     ->label('Country')
                //     ->searchable()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->color('danger') // merah
                    ->formatStateUsing(fn($record) => "{$record->country->code} - {$record->country->name}")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('identity_number')
                    ->label('Nomor ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('NamaKonsumen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('occupation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('identity_expired_at')
                    ->date()
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
