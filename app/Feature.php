<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model {

    protected $table = 'features';
    protected $primaryKey = 'feature_id';
    public $timestamps = true;
    protected $fillable = array('description', 'price_coins');

    public function users() {
        return $this->belongsToMany('App\User', 'user_feature_log', 'feature_id', 'user_id')->withTimestamps();
    }

}
