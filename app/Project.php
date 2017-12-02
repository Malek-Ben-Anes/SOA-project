<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use URL;
use App\Challenge;
use App\Freelancer;

class Project extends Model {

    protected $table = 'projects';
    public $timestamps = true;
    protected $primaryKey = 'project_id';
    protected $fillable = array(
        'title', 'description', 'duration', 'enterprise_id', 'budget', 'ending_date', 'sponsored', 'open'
    );

    public function freelancers() {
        return $this->belongsToMany('App\Freelancer', 'freelancer_project_interest', 'project_id', 'freelancer_id')->withTimestamps();
    }

    public function enterprise() {
        return $this->belongsTo('App\Enterprise', 'enterprise_id');
    }

    public function challenges() {
        return $this->hasMany('App\Challenge', 'project_id');
    }

    public function comments() {
        return $this->belongsToMany('App\User', 'challenge_comments', 'project_id', 'user_id')->withPivot([ 'project_comment_id', 'content'])->withTimestamps();
    }

    public function skills() {
        return $this->belongsToMany('App\Skill', 'project_skill_required', 'project_id', 'skill_id');
    }

    /**
     * get the particiaption number for a project (project contains a set of challenges)
     *
     * @return int
     */
    public function participationNumber() {
        $count = 0;
        //get list of challenges
        $challenges = $this->challenges()->get();
        //get number of participation for each challenge
        foreach ($challenges as $challenge) {
            $count += $challenge->freelancers()->count();
        }
        return $count;
    }

     /**
     * verify if the connected user is the owner of the project
     *
     * @return boolean
     */
    public function is_owner($user_id) {
        return $this->enterprise()->first()->enterprise_id == $user_id ? true : false;
    }

    /**
     * verify if the freelancer($freelancer_id) is has participated in this project
     *
     * @return boolean
     */
    public function is_participated($freelancer_id) {
        $challenges = $this->challenges()->get();
        foreach ($challenges as $challenge) {
            if ($challenge->is_participated($freelancer_id)) {
                return true;
            }
        }
        return false;
    }

    /**
     * get the complete data related to a project 
     * and it add it to the $this variable
     *
     * @return null
     */
    public function complete_data() { 
    //for web
        $enterprise = $this->enterprise()->first();
        $this->enterprise_name = $enterprise->enterprise_name !== null ? $enterprise->enterprise_name : 'enterprise_name';
        $this->logo = $enterprise->logo !== null ? URL::asset('/uploads/blog/image-'. ($this->project_id % 5) .'.jpg') : URL::asset('/uploads/blog/image-1.jpg');
        $this->project_image = '/uploads/blog/post-1.jpg';
        $this->interested_number = $this->freelancers()->count();
        $this->participation_number = $this->participationNumber();
        $this->skills_required = $this->skills()->get();

        if (!Auth::guest() && Auth::user()->type == "freelancer") {
            $interested_freelancer_got_by_id = $this->freelancers()->get()->where('freelancer_id', '=', Auth::user()->user_id)->first();
            $this->freelancer_interest = empty($interested_freelancer_got_by_id) ? 0 : 1;
        }
    }


    /**
     * get skill by name and return all freelancers that have this skill 
     *
     * @return array of freelancers
     */
    public function getFreelancersBySkillName($skills_array) {

        $freelancers = [];
        foreach ($skills_array as $skill) {
            $freelancers_by_skill = $skill->freelancers()->get()->all();
            $freelancers = array_merge($freelancers, $freelancers_by_skill); 
        }
        $freelancers = array_unique($freelancers);
        return $freelancers;
    }


}
