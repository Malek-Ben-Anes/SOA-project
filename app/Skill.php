<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model {

    protected $table = 'skills';
    protected $primaryKey = 'skill_id';
    public $timestamps = true;
    protected $fillable = array('title');
    protected $hidden = ['pivot'];

    /**
     * @return Array of Projects
     */
    public function projects() {
        return $this->belongsToMany('App\Project', 'project_skill_required', 'skill_id', 'project_id');
    }

    /**
     * @return boolean
     */
    public function freelancers() {
        return $this->belongsToMany('App\Freelancer', 'freelancer_skill', 'skill_id', 'freelancer_id');
    }

}
