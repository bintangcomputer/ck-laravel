<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutletResource\Pages;
use App\Filament\Resources\OutletResource\RelationManagers;
use App\Models\Outlet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OutletResource extends Resource
{
    protected static ?string $model = Outlet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(10)
                    ->disabled(fn(string $operation): bool => $operation === 'edit'),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(40),
                Forms\Components\TextInput::make('group')
                    ->required()
                    ->maxLength(1),
                Forms\Components\TextInput::make('open_clock')
                    ->required(),
                Forms\Components\TextInput::make('close_clock')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('open_clock'),
                Tables\Columns\TextColumn::make('close_clock'),
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
            'index' => Pages\ListOutlets::route('/'),
            'create' => Pages\CreateOutlet::route('/create'),
            'view' => Pages\ViewOutlet::route('/{record}'),
            'edit' => Pages\EditOutlet::route('/{record}/edit'),
        ];
    }
}
