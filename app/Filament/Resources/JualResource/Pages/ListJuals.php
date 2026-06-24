<?php

namespace App\Filament\Resources\JualResource\Pages;

use App\Filament\Resources\JualResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJuals extends ListRecords
{
    protected static string $resource = JualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
