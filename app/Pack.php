<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model {

    protected $table = 'packs';
    protected $primaryKey = 'pack_id';
    public $timestamps = true;
    protected $fillable = array('title', 'price', 'coins', 'description');

    public function transactions() {
        return $this->belongsToMany('App\User', 'transactions', 'pack_id', 'user_id')->withTimestamps();
    }

}
