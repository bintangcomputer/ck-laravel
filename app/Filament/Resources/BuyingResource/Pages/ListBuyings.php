<?php

namespace App\Filament\Resources\BuyingResource\Pages;

use App\Filament\Resources\BuyingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBuyings extends ListRecords
{
    protected static string $resource = BuyingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
