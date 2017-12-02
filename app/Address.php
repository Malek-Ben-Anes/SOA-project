<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model 
{

    protected $table = 'address';
    public $timestamps = false;
    protected $fillable = array('address', 'ville');

    public function users()
    {
        return $this->hasMany('User');
    }

}