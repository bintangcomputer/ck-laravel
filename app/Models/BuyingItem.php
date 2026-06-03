<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_code',
        'nominal',
        'buying_rate',
        'subtotal',
    ];

    public function buying()
    {
        return $this->belongsTo(Buying::class);
    }

    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class);
    }
}
