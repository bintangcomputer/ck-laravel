<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\JualItem;

class Jual extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_no',
        'date',
        'time',
        'customer_name',
        'customer_phone',
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
        return $this->hasMany(JualItem::class);
    }
}
