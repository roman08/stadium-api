<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'star_date',
        'hour',
        'id_local_team',
        'local_mummy',
        'id_visiting_team',
        'visiting_mumy',
        'observation',
        'id_working',
        'status',
        'local_marker',
        'visiting_marker'
    ];



    // En tu modelo Juego
    public function localTeam()
    {
        return $this->belongsTo(Club::class, 'id_local_team');
    }

    public function visitingTeam()
    {
        return $this->belongsTo(Club::class, 'id_visiting_team');
    }
}
