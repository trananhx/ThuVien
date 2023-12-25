<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    protected $fillable = ['id', 'content', 'is_select'];

    protected $attributes = [
        'is_select' => false,
    ];

    public function votes(){
        return $this->hasMany(Vote::class, 'question_id', 'id');
    }

    public function users(){
        return $this->hasManyThrough(UserVote::class, Vote::class, 'question_id', 'vote_id', 'id', 'id');
    }
}
