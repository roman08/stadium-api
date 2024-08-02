<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'journey_id',
        'season_id'
    ];


    public function jornada()
    {
        return $this->belongsTo(WorkingDay::class, 'journey_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Competitor::class, 'user_id');
    }
}
