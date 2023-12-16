<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    protected $fillable = ['id', 'content'];

    public function votes(){
        return $this->hasMany(Vote::class, 'question_id', 'id');
    }
}
