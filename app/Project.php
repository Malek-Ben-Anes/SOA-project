<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use URL;
use App\Challenge;
use App\Freelancer;


class Project extends Model 
{

    protected $table = 'projects';
    public $timestamps = true;
    protected $primaryKey = 'project_id';
    protected $fillable = array(
    	'title', 'description', 'duration', 'enterprise_id'
    	);



    public function freelancers()
    {
        return $this->belongsToMany('App\Freelancer', 'freelancer_project_interest', 'project_id', 'freelancer_id')->withTimestamps();
    }

    public function enterprise()
    {
        return $this->belongsTo('App\Enterprise', 'enterprise_id');
    }

    public function challenges()
    {
        return $this->hasMany('App\Challenge', 'project_id');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Skill', 'project_skill_required', 'project_id', 'skill_id');
    }

    public function participationNumber()
    {
        $count = 0;
        //get list of challenges
         $challenges = $this->challenges()->get();
         //get number of participation for each challenge
         foreach ($challenges as $challenge ) {

            $count +=  $challenge->freelancers()->count();
         }
         return $count;
    }

    public function is_owner( $user_id ) 
    {
        return $this->enterprise()->first()->enterprise_id == $user_id? true:false  ;
    }

    public function complete_data()
    {
         $enterprise = $this->enterprise()->first();
            $this->enterprise_name =  $enterprise->enterprise_name !== null ? $enterprise->enterprise_name : 'enterprise_name' ; 
            $this->logo = $enterprise->logo !== null ? URL::asset('/uploads/enterprise/images/' . $enterprise->logo ) : URL::asset('/uploads/enterprise/images/logo.png') ; 
            $this->project_image = '/uploads/projects/images/orange.png';
                $this->interested_number = $this->freelancers()->count();
                $this->participation_number = $this->participationNumber();
                 $this->skills_required = $this->skills()->get();
    }
}