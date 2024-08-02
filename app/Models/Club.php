<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo', // No es necesario especificar 'string'
        'acronym',
        'status',
        'sport_id'
    ];
}
