<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notification;
use App\Message;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;
    protected $fillable = [
    'username', 'email', 'password', 'country',
    'city', 'address', 'type', 'message_list', 'notification_list'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
    ];

    public function devices()
    {
        return $this->hasMany('Device');
    }

    public function region()
    {
        return $this->belongsTo('Address');
    }

    public function packs()
    {
        return $this->belongsTo('Pack', 'Transaction');
    }

    /**
     * methods bloc for notifications user
     */

    public function notifications()
    {
        return $this->belongsToMany('App\Notification', 'user_notification',  'notified_id', 'notification_id' )->withPivot(['notifier_id', 'notified_id', 'content'])->withTimestamps();
    }

    public function viewNewsNotif(){ //delete the attibute notifications_list form the table user
        $this->notification_list = 0;
        $this->save();
    }

     public function createNewsNotif(){ //delete the attibute notifications_list form the table user
        $this->notification_list++;
        $this->save();
    }

    public function paginatedNotifications($page = 5) //freelancer notifications
    {
        $this->viewNewsNotif();
        $notifications = $this->belongsToMany('App\Notification', 'user_notification',  'notified_id', 'notification_id' )->withPivot(['notifier_id', 'viewed', 'created_at'])->withTimestamps()->orderBy('user_notification_id', 'desc')->paginate($page);

        foreach($notifications as $notification)
        {   
             $notification->viewed = $notification->pivot->viewed;
            $enterprise = Enterprise::find($notification->pivot->notifier_id );
            unset($notification->pivot);
            if ($enterprise == null) {
                continue;
            }
            $enterprise_data= [ "enterprise_id" => $enterprise->enterprise_id,
            "enterprise_name" => $enterprise->enterprise_name,
            "logo" => $enterprise->logo];

            $notification->enterprise = (Object) $enterprise_data;                             
        }

        return $notifications;
    }

    public function notifications_web() //freelancer notifications
    {
        $this->viewNewsNotif();
        $notifications = $this->belongsToMany('App\Notification', 'user_notification',  'notified_id', 'notification_id' )->withPivot(['notifier_id'])->withTimestamps()->get();
        foreach($notifications as $notification)
        {
            $notification->enterprise = Enterprise::find($notification->pivot->notifier_id );
        }

        return $notifications;
    }


    public function newNotifications( Array $notification_ids )
    {
        if ( $notification_ids == [ 0 => ""]) {
            return ;
        }else{
            $notifications = [];
            foreach($notification_ids as $notification_id)
            {
                $notification = $this->notifications_web()->where('notification_id','=',$notification_id)->first();
                $notification->enterprise = Enterprise::find($notification->pivot->notifier_id );
                array_push($notifications, $notification);

            }
            return $notifications;
        }
    }

    public function notify($notified_id, $notification_id, $notifier_id )
    {
        $notifiedUser = User::find($notifier_id);
        $notifiedUser->createNewsNotif();
        $this->notifications()->attach($notifier_id, ['notified_id' => $notified_id, 'notification_id' => $notification_id, 'notifier_id' => $notifier_id , 'viewed' =>0]);
    }
    /**
     * // methods bloc for notifications user
     */
    


 /**
     * methods bloc for messages user
     */

     public function messages()
    {
        return $this->hasMany('App\Message', 'receiver_id', 'user_id');
    }

    public function messagesSended()
    {
        return $this->hasMany('App\Message', 'sender_id', 'user_id');
    }

    public function viewNewsmessages(){ //delete the attibute messages_list form the table user
        $this->message_list = 0;
        $this->save();
    }

     public function createNewsMessages(){ //delete the attibute messages_list form the table user
        $this->message_list++;
        $this->save();
    }

    public function paginatedMessages($page = 5) //freelancer messages
    {
        $this->viewNewsmessages();
        $messages = $this->messages()->paginate($page);
        return $messages;
    }

     public function contact($sender_id, $receiver_id, $content ) 
    {
        $message = new Message;
        $message->receiver_id = $receiver_id;
        $message->sender_id = $sender_id;
        $message->content = $content;
        $notifiedUser = User::find($receiver_id);
        $notifiedUser->createNewsMessages();
        $this->messagesSended()->save($message);
    }



}
