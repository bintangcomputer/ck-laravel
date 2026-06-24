<?php

namespace App\Filament\Pages;

use App\Models\Buying;
use Filament\Pages\Page;

class BuyingPrint extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.buying-print';

    public $buying;

    public function mount()
    {
        $id = request()->get('id');

        $this->buying = Buying::with('items')
            ->findOrFail($id);
    }
}
