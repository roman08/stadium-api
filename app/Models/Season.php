<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "star",
        "end",
        "banner",
        "status",
        "id_sport"
    ];



    public function working()
    {
        return $this->hasMany(WorkingDay::class, 'id_season');
    }
}
