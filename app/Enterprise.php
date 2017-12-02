<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model {

    protected $table = 'enterprises';
    public $timestamps = true;
    protected $primaryKey = 'enterprise_id';
    protected $fillable = array('enterprise_id', 'phone', 'enterprise_document', 'logo', 'premuim', 'coins', 'enterprise_name', 'description', 'address');

    public function projects() {
        return $this->hasMany('App\Project', 'enterprise_id');
    }

    public function freelancers() {
        return $this->belongsToMany('App\Freelancer', 'freelancer_profile_unblocked', 'enterprise_id', 'freelancer_id')->withTimestamps();
    }

    public function challenges() { // to do it again with has Many Through
        $projects = $this->projects()->get();
        $challenges = [];
        foreach ($projects as $project) {
            $challenges += $project->challenges()->get()->all();
        }
        return $challenges;
    }

    public function challengesNumber() { // to do it again with has Many Through
        $projects = $this->projects()->get();
        $challengeNumber = 0;
        foreach ($projects as $project) {
            $challengeNumber += $project->challenges()->count();
        }
        return $challengeNumber;
    }

    public function ongoingChallengesNumber() { // to do it again with has Many Through
        $projects = $this->projects()->where('open', '=', 1)->get();
        $challengeNumber = 0;
        foreach ($projects as $project) {
            $challengeNumber += $project->challenges()->count();
        }
        return $challengeNumber;
    }

    public function projects_complete_data() {
        $projects = $this->hasMany('App\Project', 'enterprise_id')->orderBy('created_at', 'desc')->get();
        // orderBy('created_at', 'desc')->paginate($this->page);

        foreach ($projects as $project) {
            $project = $project->complete_data();
        }
        return $projects;
    }

    public function is_freelancer_Unlocked($freelancer_id) {

        if ($this->freelancers()->wherePivot('freelancer_id', $freelancer_id)->first() != null) {
            return true;
        }
        return false;
    }

    public function unlockFreelancer($freelancer_id) {
        // dd($this);
        $this->freelancers()->attach($freelancer_id);
    }

}
