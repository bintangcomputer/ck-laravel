<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buying extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_no',
        'date',
        'time',
        'customer_name',
        'country_id',
        'country_code',
        'country_name',
        'total',
    ];

    protected function casts(): array
    {
        return ['date' => 'date', 'time' => 'time'];
    }

    public function items()
    {
        return $this->hasMany(BuyingItem::class);
    }
}
