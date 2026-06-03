<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'identity_number',
        'name',
        'adress',
        'phone',
        'country_id',
        'occupation',
        'identity_expired_at',
    ];

    // Related to Country
    // Snake case => customer_adresses/customer_name (digunakan untuk nama tabel atau nama kolom)
    // Pascal case => CustomerAdresses/CustomerName (digunakan untuk nama model atau nama class)
    // Camel case => customerAdresses/customerName (digunakan untuk nama method atau function atau variabel)
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
