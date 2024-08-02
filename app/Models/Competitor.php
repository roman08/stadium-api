<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Competitor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'last_name',
        'second_surname',
        'birth_date',
        'phone',
        'profile_img',
        'email',
        'password',
        'bank_id',
        'bank_account',
        'account_type_id',
        'observations',
    ];

    protected $hidden = [
        'password',
    ];
}
