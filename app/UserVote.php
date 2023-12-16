<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVote extends Model
{
    protected $table = 'user_vote';
    protected $fillable = ['user_id', 'vote_id'];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function vote(){
        return $this->belongsTo(Vote::class, 'id', 'vote_id');
    }
}
