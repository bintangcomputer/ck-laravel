<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Outlet;

class Terminal extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'terminal_code',
        'bill_code',
        'counter',
        'is_active',
    ];

    //RELASIKAN DENGAN MASTER OUTLET  
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
