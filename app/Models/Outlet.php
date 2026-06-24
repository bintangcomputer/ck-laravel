<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Terminal;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'group',
        'open_clock',
        'close_clock',
    ];

    public function terminals()
    {
        return $this->hasMany(Terminal::class);
    }
}
