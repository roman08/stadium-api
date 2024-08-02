<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "image",
        "banner",
        "exact_marker_points",
        "points_winner_loser",
        "tie_points",
        "points_lost",
        "participant_fee",
        "platform_commission",
        "status"
    ];



    public function seasons()
    {
        return $this->hasMany(Season::class, 'id_sport');
    }

    public function clubs()
    {
        return $this->hasMany(Club::class, 'sport_id');
    }
}
