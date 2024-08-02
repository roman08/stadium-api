<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'star',
        'end',
        'end_register',
        'status',
        'id_season'
    ];

    public function games()
    {
        return $this->hasMany(Game::class, 'id_working');
    }
}
