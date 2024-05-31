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
        'name', 'email', 'password','role','phone','ma_sv'
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
    protected $casts = ['email_verified_at' => 'datetime', ];

    public function votes(){
        return $this->belongsToMany(Vote::class, 'user_vote', 'user_id', 'vote_id', 'id', 'id');
    }

    public function yeucau(){
        return $this->hasMany(YeuCau::class, 'user_id', 'id');
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new \App\Notifications\CustomResetPasswordNotification($token));
    }
}
