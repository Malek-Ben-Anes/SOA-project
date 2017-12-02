<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model 
{

    protected $table = 'enterprises';
    public $timestamps = false;
      protected $primaryKey = 'enterprise_id';
    protected $fillable = array('enterprise_id', 'phone', 'enterprise_document', 'logo', 'premuim', 'coins',  'enterprise_name');

    public function projects()
    {
        return $this->hasMany('App\Project', 'enterprise_id');
    }

    public function freelancers()
    {
        return $this->belongsToMany('App\Freelancer', 'freelancer_profile_unblocked', 'enterprise_id', 'freelancer_id');
    }

    public function challenges() // to do it again with has Many Through
    {

        $projects = $this->projects()->get();
        $challenges = [];
        foreach ( $projects  as $project) {
            $challenges += $project->challenges()->get()->all();
        }
        return  $challenges ;
    }

     public function projects_complete_data()
    {
        $projects = $this->hasMany('App\Project', 'enterprise_id')->get();
        
        foreach ($projects as $project)
         {
            $project = $project->complete_data();
        }
        return $projects;
    }  

    public function is_freelancer_Unlocked($freelancer_id) {
        if ($this->freelancers()->wherePivot('freelancer_id', $freelancer_id)->first() != null)  {
            return true;
        }
        return false;
    }
     public function unlockFreelancer($freelancer_id) {
            
            $this->freelancers()->attach($freelancer_id);
        }

}