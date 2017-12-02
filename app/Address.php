<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'address';
    public $timestamps = false;
    protected $fillable = array('address', 'ville');

    public function users() {
        return $this->hasMany('User');
    }

}
