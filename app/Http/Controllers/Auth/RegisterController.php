<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Freelancer;
use App\Enterprise;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function freelancerValidator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|min:4|max:255',
            'last_name' => 'required|string|min:4|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'phone' => 'required|numeric|min:1000',
            'address' => 'string|min:4|max:255',
        ]);
    }

   

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([            
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'type' => $data['type'],
        ]);
    }

   
    /**
     * Create a new controller instance.
     *verify if the validation of input provided with $request variable
     * @return json object response
     */
    protected function registerFreelancer(Request $request)
    {
         if (Auth::guest()) {

        $data = $request->all();
        $data["type"] = "freelancer";
        $data["username"] = $request->first_name;
        // $user contain the input of user registration
         $validation = $this->freelancerValidator($data);
        //if there is any validation mistake then we return the mistakes errors
         if ($validation->fails()) 

         {


            $error["code"] = 400;
            $error["message"] = $validation->errors() ;
            $response=array("status"=>false,
                           "error"=> $error);
            // return json_decode(json_encode($nested_object), true);

                 
         } 
          //if the validation of the registration is correct 
         // the we  return the newUser object 
         else
         {

                $newUser = new User;
                $newUser=  $this->create($data);
                $newFreelancer = new Freelancer;
                Freelancer::create( [  "freelancer_id"  => $newUser->user_id,
                					   "first_name"  => $request->first_name,
                					   "last_name"  => $request->last_name,
                                       "phone" => $request->phone,
                                       "pseudonym" => 'freelancer-' . str_random(5)    
                                    ]);
                $user = DB::table('users')->where('user_id', $newUser->user_id)->first();
                 unset($user->password);
                $response=array(  "status"=>true,
                                  "data"=>$user);
                if(Auth::attempt(['email' => $request->email,
                  'password' => $request->password ], true));
         }

        }else{

        $response=array("status"=>true,
                        "message" => "you are already connected, you can't sign up");
    }

        return response()->json($response,200);
    }


     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function enterpriseValidator(array $data)
    {
        return Validator::make($data, [
            'enterprise_name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'phone' => 'required|numeric',
            'attach_document'=>'required|file'
        ]);
    }

    /**
     * Create a new controller instance.
     *verify if the validation of input provided with $request variable
     * @return json object response
     */
    protected function registerEnterprise(Request $request)
    {
        

        if (Auth::guest()) {
         $data = $request->all();
        $data["type"] = "enterprise";
         $data["username"] = $request->enterprise_name;
        // $user contain the input of user registration
         $validation = $this->enterpriseValidator($data);
        //if there is any validation mistake then we return the mistakes errors
         if ($validation->fails()) 

         {

                  $response=array( "status"=>false,
                    "error"=>$validation->errors());

         } 
    
         else{

             //if the validation of the registration is correct 
             //we create a new user 
             //we create his profile 
             //we upload his document
            // then we  return the newUser object 
                
                $newUser = new User;
                 $newUser=  $this->create($data);
                $newEnterprise = new Enterprise;

                $file = Input::file('attach_document');
                $destinationPath= public_path().'/uploads/enterprise/enterprise_documents';
                $random_name = str_random(8);
                $extension = $file->getClientOriginalExtension();
                $filename=   $newUser->username . $random_name .'.' .$extension;
                $request->file('attach_document')->move($destinationPath, $filename) ;

                Enterprise::create( [  "enterprise_id"  => $newUser->user_id,
                                        "enterprise_name" => $request->enterprise_name,
                                        "enterprise_document" => $filename,
                                        "phone" => $request->phone
                                    ]);

                $user = DB::table('users')->where('user_id', $newUser->user_id)->first();
                 unset($user->password);

                $response=array(  "status"=>true,
                                  "data"=>$user);
                if(Auth::attempt(['email' => $request->email,
                  'password' => $request->password ], true));


         }
      }else{

        $response=array("status"=>true,
                        "message" => "you are already connected, you can't sign up");
    }


        return response()->json($response,201);
    }




    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerUserFreelancer(Request $request)
    {
        $request["type"] = "freelancer";
        $validator = $this->freelancerValidator($request->all());
 
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
 
        $this->create($request->all());
 
        return response()->json();
    }

  
  



}