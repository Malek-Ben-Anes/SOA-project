<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model 
{

    protected $table = 'skills';
     protected $primaryKey = 'skill_id';
    public $timestamps = false;
    protected $fillable = array('title');
    protected $hidden = ['pivot'];

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'project_skill_required', 'skill_id', 'project_id');
    }

    public function freelancers()
    {
        return $this->belongsToMany('App\Freelancer', 'freelancer_skill','skill_id', 'freelancer_id' );

    }

}