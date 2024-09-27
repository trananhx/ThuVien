<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    public $timestamps = ["created_at"];
    const UPDATED_AT = null;
    protected $fillable = ['email', 'token'];
}
