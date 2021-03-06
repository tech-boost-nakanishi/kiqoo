<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','qualification', 'hobby', 'introduction', 'email_verify_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany("App\Question");
    }

    public function answers()
    {
        return $this->hasMany("App\Answer");
    }

    public static function boot() 
    {
        parent::boot();
        static::deleting(function($user) {
            foreach ($user->questions()->get() as $child) {
                $child->delete();
            }

            foreach ($user->answers()->get() as $child) {
                $child->delete();
            }
        });
    }
}
