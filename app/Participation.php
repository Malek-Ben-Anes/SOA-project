<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model {

    public function project() {
        return $this->belongsToMany('App\Project', 'project_id');
    }

}
