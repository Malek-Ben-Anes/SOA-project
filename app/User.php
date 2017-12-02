<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notification;
use App\Message;
use DB;

class User extends Authenticatable {

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
        'username', 'email', 'password', 'country', 'image',
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

    public function devices() {
        return $this->hasMany('Device');
    }

    public function region() {
        return $this->belongsTo('Address');
    }

    /**
     * @return all last transactions dones by the user
     */
    public function transactions() {
        return $this->belongsToMany('App\Pack', 'transactions', 'user_id', 'pack_id')->withTimestamps();
    }

    /**
     * @return all the available features in this plateforme
     */
    public function features() {
        return $this->belongsToMany('App\Feature', 'user_feature_log', 'user_id', 'feature_id')->withPivot(['description', 'enterprise_name'])->withTimestamps();
    }

    /**
     * @return all user notifications
     */
    public function notifications() {
        return $this->belongsToMany('App\Notification', 'user_notification', 'notified_id', 'notification_id')->withPivot(['notifier_id', 'notified_id', 'content'])->withTimestamps();
    }

    /**
     * it will delete the attibute notifications_list form the table user
     * 
     * @return null
     */
    public function viewNewsNotif() { 

        $this->notification_list = 0;
        $this->save();
    }

    /**
     * increment the attibute notifications_list form the table user
     * 
     * @return null 
     */
    public function createNewsNotif() { 
        $this->notification_list++;
        $this->save();
    }

    /**
     * get the notifications orderd by desc date for the web service mobile
     * must put ?page=x in the url
     *
     * @param number notifications per page
     * 
     * @return notifications 
     */
    public function paginatedNotifications($page = 5) { 
    //freelancer notifications
        $this->viewNewsNotif();
        $notifications = $this->belongsToMany('App\Notification', 'user_notification', 'notified_id', 'notification_id')->withPivot(['notifier_id', 'viewed'])->withTimestamps()->orderBy('user_notification_id', 'desc')->paginate($page);

        foreach ($notifications as $notification) {
            $notification->viewed = $notification->pivot->viewed;
            // dd($notification->pivot->created_at->
            $notification->created_at = $notification->pivot->created_at->toDateTimeString();
            ;
            $enterprise = Enterprise::find($notification->pivot->notifier_id);
            unset($notification->pivot);
            if ($enterprise == null) {
                continue;
            }
            $enterprise_data = [ "enterprise_id" => $enterprise->enterprise_id,
                "enterprise_name" => $enterprise->enterprise_name,
                "logo" => '/uploads/enterprise/images/' . ($enterprise->logo == null ? 'logo.png' : $enterprise->logo)];

            $notification->enterprise = (Object) $enterprise_data;
        }

        return $notifications;
    }

    /**
     * get the notifications orderd by desc date for the web (WEB)
     * must put ?page=x in the url
     *
     * @param number notifications per page
     * 
     * @return notifications 
     */
    public function notifications_web() { 
    //freelancer notifications
        $this->viewNewsNotif();
        $notifications = $this->belongsToMany('App\Notification', 'user_notification', 'notified_id', 'notification_id')->withPivot(['notifier_id'])->withTimestamps()->get();
        foreach ($notifications as $notification) {
            $notification->enterprise = Enterprise::find($notification->pivot->notifier_id);
        }

        return $notifications;
    }

    /**
     *
     * @param number notifications per page
     * 
     * @return notifications 
     */
    public function newNotifications(Array $notification_ids) {
        if ($notification_ids == [ 0 => ""]) {
            return;
        } else {
            $notifications = [];
            foreach ($notification_ids as $notification_id) {
                $notification = $this->notifications_web()->where('notification_id', '=', $notification_id)->first();
                $notification->enterprise = Enterprise::find($notification->pivot->notifier_id);
                array_push($notifications, $notification);
            }
            return $notifications;
        }
    }

    public function notify($notified_id, $notification_id, $notifier_id) {
        $notifiedUser = User::find($notified_id);
        $notifiedUser->createNewsNotif();
        $this->notifications()->attach($notifier_id, ['notified_id' => $notified_id, 'notification_id' => $notification_id, 'notifier_id' => $notifier_id, 'viewed' => 0]);
    }

    /**
     * // methods bloc for notifications user
     */

    /**
     * methods bloc for messages user
     */
    public function messages() {
        return $this->hasMany('App\Message', 'receiver_id', 'user_id');
    }

    public function comments() {
        return $this->belongsToMany('App\Project', 'challenge_comments', 'user_id', 'project_id')->withPivot(['content'])->withTimestamps();
    }

    public function messagesSended() {
        return $this->hasMany('App\Message', 'sender_id', 'user_id');
    }

    public function viewNewsmessages() { //delete the attibute messages_list form the table user
        $this->message_list = 0;
        $this->save();
    }

    public function createNewsMessages() { //delete the attibute messages_list form the table user
        $this->message_list++;
        $this->save();
    }

    // $messages_ids = DB::table('messages')->distinct('sender_id')->select('sender_id', 'receiver_id','updated_at')->orderBy('updated_at', 'desc')->where(['receiver_id' => $this->user_id])->groupBy('sender_id','receiver_id', 'updated_at')->paginate($page);
    //   dd($messages_ids->all());
    //   // to add orWhere(['receiver_id' => $message->sender_id) for getting message from user who has sended for the first time  ->distinct()
    //   $messages =[];
    //   $a = 0;
    //   foreach ($messages_ids as $message) {
    //       $message = $this->messages()->where(['receiver_id' => $message->receiver_id, 'sender_id' => $message->sender_id])->orWhere(['receiver_id' => $message->sender_id, 'sender_id' => $message->receiver_id])->orderBy('updated_at', 'desc')->first();
    //       array_push($messages, $message);
    //   }
    //   return $messages;
    //   return array_unique($messages);
    //to rectify give last messages
    public function paginatedMessages($page = 5) { //freelancer messages
        $this->viewNewsmessages();
        $messages_ids = DB::table('messages')->distinct()->select('sender_id', 'receiver_id')->where(['receiver_id' => $this->user_id])->orWhere('sender_id', '=', 'John')->groupBy('sender_id', 'receiver_id')->paginate($page);
        // dd($messages_ids);
        $messages = [];
        foreach (array_reverse($messages_ids->all()) as $message) {
            // $message = $this->messages()->where(['receiver_id' => $message->receiver_id, 'sender_id' => $message->sender_id])->orderBy('updated_at', 'desc')->first();
            $message = $this->messages()->orderBy('created_at', 'desc')->where([['receiver_id', '=', $message->receiver_id], ['sender_id', '=', $message->sender_id]])->orWhere([['receiver_id', '=', $message->sender_id], ['sender_id', '=', $message->receiver_id]])->first();
            if ($message->sender_id == $this->user_id) {
                //viewed =1 to meean that it is showed for the sender 
                $message->viewed = 1;
            }
            array_push($messages, $message);
        }

        // usort($messages, function($a, $b){    return strcmp($a->message_id, $b->message_id); });   



        return $messages;
    }

    public function paginatedDiscussion($page = 5, $sender_id) { //freelancer messages
        $messages = $this->messages()->orderBy('updated_at', 'desc')->where([['receiver_id', '=', $this->user_id], ['sender_id', '=', $sender_id]])->orWhere([['receiver_id', '=', $sender_id], ['sender_id', '=', $this->user_id]])->paginate($page);
        $last_message_in_user_discussion = $messages->first();
        if ($last_message_in_user_discussion && $last_message_in_user_discussion->receiver_id == $this->user_id) {
            $last_message_in_user_discussion->viewed = 1;
            $last_message_in_user_discussion->save();
        }
        return $messages;
    }

    public function contact($sender_id, $receiver_id, $content) {
        $message = new Message;
        $message->receiver_id = $receiver_id;
        $message->sender_id = $sender_id;
        $message->content = $content;
        $notifiedUser = User::find($receiver_id);
        $notifiedUser->createNewsMessages();
        $this->messagesSended()->save($message);
    }

    public function setCoinsAmount($amount) {

        if (Auth::user()->type == "freelancer") {

            $user = Freelancer::find(Auth::user()->user_id);
            if ($user->coins > $amount) {
                $user->update(["coins" => $user->coins - $amount]);
                return true;
            }else{
                return false;
            }

        } elseif (Auth::user()->type == "enterprise") {

            $user = Enterprise::find(Auth::user()->user_id);
            if ($user->coins > $amount) {
            $user->update(["coins" => $user->coins - $amount]);
            return true;
            }else{
                return false;
            }
        }
    }

    // this function is for mobile api
    public function setCoinsAmountByUserId($amount) {

            $freelancer = Freelancer::find($this->user_id);
            if ($freelancer->coins > $amount) {
                $freelancer->update(["coins" => $freelancer->coins - $amount]);
                return true;
            }else{
                return false;
            }
    }

}
