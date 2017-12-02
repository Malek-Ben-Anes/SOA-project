<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Notification extends Model 
{

    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    public $timestamps = false;
    protected $fillable = array('title');
    // protected $hidden = ['pivot'];

// return all notifications for the notified user
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_notification', 'notification_id',  'notified_id' )->withPivot('notifier_id', 'viewed')->withTimestamps();
    }

}