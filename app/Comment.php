<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model 
{

    protected $table = 'challenge_comments';
    public $timestamps = true;

    public function challenge()
    {
        return $this->belongsTo('App\Challenge');
         return $this->belongsTo()('App\Criterion', 'challenge_id', 'criterion_id');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}