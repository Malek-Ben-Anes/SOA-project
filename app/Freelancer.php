<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Skill;
use App\Project;
use App\Challenge;

class Freelancer extends Model 
{

    protected $table = 'freelancers';
    public $timestamps = false;
    protected $primaryKey = 'freelancer_id';
    protected $hidden = ['pivot'];
    protected $fillable = array( 'freelancer_id', 'phone',
     'image', 'premium', 'coins', 'first_name', 'last_name', 'freelancer_curriculum_vitae', 'freelancer_id', 'description', 'short_description',
     'address','country', 'city', 'postal_code','pseudonym' );

    public function challenges()
    {
        return $this->belongsToMany('App\Challenge', 'challenge_freelancer_participation','freelancer_id', 'challenge_id')->withPivot(['freelancer_participation_id', 'message', 'document', 'viewed'])->withTimestamps();

    }

    public function skills()
    {
        return $this->belongsToMany('App\Skill', 'freelancer_skill', 'freelancer_id', 'skill_id'
            );
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'freelancer_project_interest', 'freelancer_id', 'project_id')->withTimestamps();
    }

    public function enterprises()
    {
        return $this->belongsToMany('App\Enterprise', 'freelancer_profile_unblocked', 'freelancer_id', 'enterprise_id');
    }
    
    public function criterions()
    {
        return $this->belongsToMany('App\Criterion', 'freelancer_criterion_evaluation', 'freelancer_id', 'criterion_id')->withPivot('mark');
    }


}