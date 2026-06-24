<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JualItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_rate_id',
        'currency_code',
        'nominal',
        'selling_rate',
        'subtotal',
    ];

    public function jual()
    {
        return $this->belongsTo(Jual::class);
    }

    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class);
    }
}
