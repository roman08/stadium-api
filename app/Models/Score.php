<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_user_id',
        'home_score',
        'away_score',
        'user_id',
    ];

    /**
     * Get the day user that owns the score.
     */
    public function dayUser()
    {
        return $this->belongsTo(DayUser::class);
    }
}
