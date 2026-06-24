<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TerminalResource\Pages;
use App\Filament\Resources\TerminalResource\RelationManagers;
use App\Models\Terminal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Outlet;

class TerminalResource extends Resource
{
    protected static ?string $model = Terminal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('outlet_id')
                //     ->label('Outlet')
                //     ->relationship('outlet', 'name')
                //     ->searchable()
                //     ->preload()
                //     ->required(),
                // Forms\Components\Select::make('outlet_id')
                //     ->label('Outlet')
                //     ->relationship(
                //         name: 'outlet',
                //         titleAttribute: 'name'
                //     )
                //     ->getOptionLabelFromRecordUsing(
                //         fn($record) => "{$record->code} - {$record->name}"
                //     )
                //     ->searchable()
                //     ->preload()
                //     ->required(),

                Forms\Components\Select::make('outlet_id')
                    ->label('Outlet')
                    ->relationship(
                        name: 'outlet',
                        titleAttribute: 'name'
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn($record) => "{$record->code} - {$record->name}"
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    // ***                    
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {

                        $billCode = $get('bill_code');

                        if (!$state || !$billCode) {
                            return;
                        }

                        $outlet = Outlet::find($state);

                        if (!$outlet) {
                            return;
                        }

                        $set(
                            'terminal_code',
                            $outlet->code . '.' . strtoupper($billCode)
                        );
                    })

                    // ***
                    ->required(),

                // Forms\Components\TextInput::make('bill_code')
                //     ->label('Bill Code')
                //     ->required()
                //     ->maxLength(5),
                // Forms\Components\TextInput::make('bill_code')
                //     ->label('Bill Code')
                //     ->readOnly(),
                Forms\Components\TextInput::make('bill_code')
                    ->label('Bill Code')
                    ->placeholder('AA / AB / AC / BA / BB')
                    ->maxLength(5)
                    // ->afterStateUpdated(function ($state, callable $set) {
                    //     $set('bill_code', strtoupper($state));
                    // })

                    // ****                    
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {

                        $outletId = $get('outlet_id');

                        if (!$outletId || !$state) {
                            return;
                        }

                        $outlet = Outlet::find($outletId);

                        if (!$outlet) {
                            return;
                        }

                        $set(
                            'terminal_code',
                            $outlet->code . '.' . strtoupper($state)
                        );
                    })
                    // ***                    
                    ->extraInputAttributes([
                        'style' => 'text-transform: uppercase',
                    ])
                    ->live(onBlur: true)
                    ->dehydrateStateUsing(fn($state) => strtoupper($state))
                    ->required(),



                // Forms\Components\TextInput::make('terminal_code')
                //     ->label('Kode Terminal')
                //     ->required()
                //     ->unique(ignoreRecord: true)
                //     ->maxLength(10)
                //     ->placeholder('01.AA'),
                // Forms\Components\TextInput::make('terminal_code')
                //     ->label('Kode Terminal')
                //     ->required()
                //     ->unique(ignoreRecord: true)
                //     ->maxLength(10)
                //     ->live(onBlur: true)
                //     ->placeholder('01.AA')
                //     ->afterStateUpdated(function ($state, callable $set) {

                //         if (str_contains($state, '.')) {

                //             $parts = explode('.', $state);

                //             $billCode = $parts[1] ?? '';

                //             $set('bill_code', strtoupper($billCode));
                //         }
                //     }),

                Forms\Components\TextInput::make('terminal_code')
                    ->label('Terminal Code')
                    ->readOnly()
                    ->dehydrated()
                    ->required(),



                Forms\Components\TextInput::make('counter')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('terminal_code')
                    ->label('Terminal')
                    ->searchable(),

                Tables\Columns\TextColumn::make('outlet.code')
                    ->label('Outlet'),

                Tables\Columns\TextColumn::make('outlet.name')
                    ->label('Nama Outlet')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bill_code')
                    ->label('Bill'),

                Tables\Columns\TextColumn::make('counter')
                    ->label('Counter'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make()
            ])

            ->defaultSort('terminal_code');
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
            'index' => Pages\ListTerminals::route('/'),
            'create' => Pages\CreateTerminal::route('/create'),
            'view' => Pages\ViewTerminal::route('/{record}'),
            'edit' => Pages\EditTerminal::route('/{record}/edit'),
            // 'edit' => Pages\DeleteTerminal::route('/{record}/edit'),
        ];
    }
}
