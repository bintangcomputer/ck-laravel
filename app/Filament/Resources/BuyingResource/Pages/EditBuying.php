<?php

namespace App\Filament\Resources\BuyingResource\Pages;

use App\Filament\Resources\BuyingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBuying extends EditRecord
{
    protected static string $resource = BuyingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
