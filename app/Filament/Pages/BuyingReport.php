<?php

namespace App\Filament\Pages;

use App\Models\Buying;
use Filament\Pages\Page;

class BuyingReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan Pembelian';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $title = 'Laporan Pembelian';

    protected static string $view = 'filament.pages.buying-report';

    public $dateFrom;

    public $dateTo;

    public $buyings = [];

    public $grandTotal = 0;

    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo   = now()->format('Y-m-d');

        //Perintah ini, langsung tampil data dari tgl.01 sd tgl. hari ini dalam bulan    
        //$this->tampilkan();  
    }



    // public function tampilkan()
    // {
    //     $this->buyings = Buying::query()
    //         ->whereBetween('date', [
    //             $this->dateFrom,
    //             $this->dateTo,
    //         ])
    //         ->orderBy('date')
    //         ->get();
    // }


    public function tampilkan()
    {
        $this->buyings = Buying::query()
            ->whereBetween('date', [
                $this->dateFrom,
                $this->dateTo,
            ])
            ->orderBy('date')
            ->get();

        //$this->grandTotal = $this->buyings->sum('total');
        $this->grandTotal = collect($this->buyings)->sum('total');
    }
}
