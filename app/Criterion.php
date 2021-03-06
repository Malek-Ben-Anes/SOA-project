<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Challenge;

class Criterion extends Model {

    protected $table = 'criterions';
    protected $primaryKey = 'criterion_id';
    public $timestamps = true;
    protected $fillable = array('title', 'challenge_id');

    public function challenges() {
        return $this->belongsTo('App\Challenge', 'challenge_id');
    }

    public function freelancers() {
        return $this->belongsToMany('App\Freelancer', 'freelancer_criterion_evaluation', 'criterion_id', 'freelancer_id');
    }

}
