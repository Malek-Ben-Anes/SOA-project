<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }


    /**
     * login user.
     *
     * @param  Request  $request
     * @return Json : status , code , data(USER)
     * @return Json : \app\User
     */

    public function loginUser(Request $request)
        {

            $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];

        if(Auth::attempt($credentials, true)) {
                
            $user = new User ;
            $user = DB::table('users')->where('email', $credentials['email'])->first();
            unset($user->password);
            $user->message_list = $user->message_list != null ? $user->message_list:0 ;
            $user->notification_list = $user->notification_list != null ? $user->notification_list:0 ;
            $response=array("status"=>true,"data"=>$user);
        }else{
            $error["code"] = 400;
            $error["message"] = "invalid credentials";
            $response=array("status"=>false,
                           "error"=>$error);
        }

            return response()->json($response,200);
            
    }

    public function logoutUser(Request $request){

        Auth::logout();
        $response=array("status"=>true,
                        "message" => "you are logged out");
        return response()->json($response,200);

    }






   public function getById($id)
    {
        dd(DB::table('users')->where('user_id', $id));
        return $user->username;

    }

    public function getByMail($email)
    {
        dd(DB::table('users')->where('email', $email));
        return $user->username;

    }

    /**
     * Show the profile for the given user.
     */
    public function showProfile($id)
    {
        $user = User::find($id);

        return $response=array("status"=>true,
                           "data"=>$user
                           );

        return View::make('user.profile', array('user' => $user));
    }





}
