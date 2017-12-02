<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use URL;
use App\Project;
use App\Criterion;

class Challenge extends Model {

    protected $table = 'challenges';
    protected $primaryKey = 'challenge_id';
    public $timestamps = true;
    protected $fillable = array('title', 'description', 'project_id');

    public function freelancers() {
        return $this->belongsToMany('App\Freelancer', 'challenge_freelancer_participation', 'challenge_id', 'freelancer_id')->withPivot(['freelancer_participation_id', 'message', 'document', 'viewed'])->withTimestamps();
    }

    public function project() {
        return $this->belongsTo('App\Project', 'project_id');
    }

    public function criterions() {
        // dd(Criterion::all());
        // dd( Criterion::all());
        // return Criterion::all();
        // dd($this->hasMany('App\Criterion', 'criterion_id')->first());
        // dd($this->hasMany('App\Criterion','challenge_id')->get() );
        return $this->hasMany('App\Criterion', 'challenge_id');
    }

    public function enterprise() { //using hasManyThrough
        return $this->belongsTo('App\Criterion', 'challenge_id', 'criterion_id');
    }

    public function is_owner($user_id) {
        return $this->project()->first()->enterprise_id == $user_id ? true : false;
    }

    public function is_participated($freelancer_id) {
        $freelancer = $this->freelancers()->wherePivot('freelancer_id', '=', $freelancer_id)->first();
        if ($freelancer == null) {
            return false;
        }
        return true;
    }

    public function participations() {
        $freelancers_participations = $this->belongsToMany('App\Freelancer', 'challenge_freelancer_participation', 'challenge_id', 'freelancer_id')->withPivot(['freelancer_participation_id', 'message', 'document', 'viewed'])->withTimestamps()->get();

        $participatons = [];
        foreach ($freelancers_participations as $freelancer_participation) {

            $participaton = $freelancer_participation->pivot;
            $participaton->participaton_id = $freelancer_participation->pivot->freelancer_participation_id;
            $participaton->pseudonym = $freelancer_participation->pseudonym;
            $participaton->freelancer_id = $freelancer_participation->freelancer_id;
            $participaton->document = URL::asset('/uploads/projects/challenges/freelancersWork/' . $freelancer_participation->pivot->document);
            array_push($participatons, $participaton);
        }
        return $participatons;
    }

    public function participation($participaton_id) {
        $freelancer_participation = $this->belongsToMany('App\Freelancer', 'challenge_freelancer_participation', 'challenge_id', 'freelancer_id')->withPivot(['freelancer_participation_id', 'message', 'document', 'viewed', 'paritcipation_url'])->withTimestamps()->wherePivot('freelancer_participation_id', '=', $participaton_id)->first();
        $freelancer_participation->pivot->document = URL::asset('/uploads/projects/challenges/freelancersWork/' . $freelancer_participation->pivot->document);
        return $freelancer_participation;
    }

    public function is_destroyable() {

        if ($this->freelancers()->first() == null) {
            return true;
        }

        return false;
    }

    public function participationNumber() {

            return $this->freelancers()->get()->count();
        }

}
