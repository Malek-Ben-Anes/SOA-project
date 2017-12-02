<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $table = 'messages';
    public $timestamps = true;
    protected $primaryKey = 'message_id';
    protected $fillable = array('content');

    /**
     * @return Object User
     */
    public function sender() {
        return $this->belongsTo('App\User', 'sender_id');
    }

    /**
     * @return Object User
     */
    public function receiver() {
        return $this->belongsTo('App\User', 'receiver_id');
    }

}
