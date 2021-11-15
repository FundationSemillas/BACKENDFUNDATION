<?php

namespace App\Models;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'permission',
        //'rol_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function events(){
        return $this->hasMany(Event::class);
    }

    public function children(){
        return $this->hasMany(Children::class);
    }

    public function rol(){
        return $this->belongsTo(Rols::class);
    }
}
