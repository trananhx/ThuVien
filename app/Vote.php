<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'vote';
    protected $fillable = ['id', 'name', 'question_id'];


    public function users(){
        return $this->belongsToMany(User::class, 'user_vote', 'vote_id', 'user_id', 'id', 'id');
    }

    public function question(){
        return $this->belongsTo(Question::class, 'id', 'question_id');
    }
}
