<?php 

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Challenge;
use App\Freelancer;
use App\User;
use App\Skill;
use App\Criterion;
use App\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use File;
use URL;
use App\UploadedFile;
use App\Http\Requests\FreelancerRequest;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freelancers = DB::table('freelancers')->paginate(15);
        $users = DB::table('users')->paginate(15);

        // $freelancers->email = $users;
        // dd($freelancers);
        return view('freelancers.index', compact('users','freelancers'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $freelancers = Freelancer::all();

        // return view('freelancers.create', compact('freelancers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(FreelancerRequest $request)
    {
        // $freelancer = Freelancer::create($request->all());
        // $freelancer->save();
        // return redirect()->route('freelancer.index')->with('message', 'item has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Freelancer $freelancer)
    {
      $enterprise = Enterprise::find(Auth::user()->user_id);
        $skills = $freelancer->skills()->get();
      if ($enterprise->is_freelancer_Unlocked($freelancer->freelancer_id) ) {
       
        $challenges = $freelancer->challenges()->get();
        $projects = $freelancer->projects()->get();
        return view('freelancers.show', compact('freelancer', 'skills', 'projects', 'challenges'));
      }

        return view('freelancers.showLocked', compact('freelancer', 'skills'));
        // dd($challenges);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showInterestedProject()
    {
         if(  Auth::guest()){
            $response=array("status"=>false,
                "error"=>"unauthorized");
        }else{

        $freelancer = Freelancer::find(Auth::user()->user_id);
        $projects = $freelancer->projects()->paginate(4);
        foreach($projects as $project){
             
            $enterprise = Enterprise::find($project->enterprise_id);
            $project->enterprise_name =  $enterprise->enterprise_name !== null ? $enterprise->enterprise_name : 'enterprise_name' ; 
            $project->logo = $enterprise->logo !== null ? URL::asset('/uploads/enterprise/images/' . $enterprise->logo ) : URL::asset('/uploads/enterprise/images/logo.png') ; 
            $project->project_image = '/uploads/projects/images/orange.png';

            $interested_freelancers_number = $project->freelancers()->count();
                $project->interested_number = $interested_freelancers_number;
                $project->participation_number = $project->participationNumber();

            $project->skills_required = $project->skills()->get();
      
                $project->freelancer_interest = 1;

        }

        }
        return view('projects.indexDetail', compact('projects'));
    }
    /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function showParticipatedChallenge()
        {

            if(  Auth::guest()){
            $response=array("status"=>false,
                "error"=>"unauthorized");
        }else{

        $freelancer = Freelancer::find(Auth::user()->user_id);
            $challenges = $freelancer->challenges()->get();
            foreach ($challenges as $challenge) {

            $marks = $freelancer->criterions()->where('challenge_id','=', $challenge->challenge_id) ->get();
              $average = 0;
              foreach ($marks as $mark ) {
                $average = $average + $mark->pivot->mark ;
              }
              $challenge->markAverage = count($marks)==0? '-' : number_format($average / count($marks) , 2);
            }
            }
            // dd($challenge);
            return view('challenges.indexWithMark', compact('challenges','criterions','freelancer'));
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Freelancer $freelancer)
    {
        $all_skills = Skill::all()->all();
        $freelancer_skills = $freelancer->skills()->get();
        return view('freelancers.edit', compact('freelancer', 'freelancer_skills','all_skills'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( FreelancerRequest $request, Freelancer $freelancer)
    {
        $freelancer->update($request->all());

         $all_skills = Skill::all()->all();
        $freelancer_skills = $freelancer->skills()->get();
        return view('freelancers.edit', compact('freelancer', 'freelancer_skills','all_skills'));


    }

    public function changeOnlyFreelancerImageWeb( Request $request )
    {

         if(  Auth::guest()){
            $response=array("status"=>false,
                "error"=>"unauthorized");
        }else{

              if ( $request->file('image')  == null) {
               
                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated, image empty");

                 }else{
                        if ($request->file('image')->isValid()) {
                            $file = Input::file('image');
                            $destinationPath= public_path().'/uploads/freelancer/images';
                            $random_name = '_' . str_random(10);
                            $extension = $file->getClientOriginalExtension();
                            $filename=   $request->user_id . $random_name .'.' .$extension;
                            $request->file('image')->move($destinationPath, $filename) ;
                            $data ['image'] = $filename;
                            $freelancer = Freelancer::find( Auth::user()->user_id );
                            File::delete($destinationPath . '/' .$freelancer->image);
                              $update  = $freelancer->update($data)     ;

                        if ($update) {
                            $response=array("status"=>true,
                            "data"=>"freelancer image has been updated" );
                        }else{

                            $response=array("status"=>false,
                            "error"=>"freelancer profile can't  be updated");
                        }

            }
        }
    }
                return redirect()->back();
                return response()->json($response,201);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Freelancer $freelancer )
    {

        // user where first return a USER object 
         $user = User::where("user_id","=", $freelancer->freelancer_id )->First();
         $freelancer->delete();
         $user->delete();
        return redirect()->route('freelancer.index')->with('message', 'item has been deleted successfully') ;

    }



    public function getAllFreelancers(){
        $freelancers=Freelancer::orderBy('freelancer_id', 'asc')->get();
       
            $response=array("status"=>true,
                "data"=>$freelancers);
        
        return response()->json($response,200);
    }

    
     public function getFreelancerById($freelancer_id)
    {
        $freelancer=Freelancer::where("freelancer_id","=",$freelancer_id)->First();
        if($freelancer==null){
            $response=array("status"=>false,
                "error"=>"no freelancer with this id");
        }
        else{
            $response=array("status"=>true,
                "data"=>$freelancer );
        }
        return response()->json($response,200);
    }


    protected function freelancerUpdateValidator(array $data)
    {
        return Validator::make($data, [

            'user_id' => 'required',
            // 'username' => 'required|string|max:255|unique:users',
            // 'first_name' => 'required|string|max:255',
            // 'last_name' => 'required|string|max:255',
            // 'country' => 'required|string|max:255',
            // 'city' => 'required|string|max:255',
            // 'address' => 'required|string|max:255',
            // 'postal_code' => 'required|numeric',
            // 'short_description' => 'required|string|min:6max:255',
            // 'description' => 'required|string',

        ]);
    }


     public function changeFreelancerProfile( Request $request )
    {

            $data = $request->all();
            $validation = $this->freelancerUpdateValidator( $data  );           

            if ($validation->fails()) 

         {
                  $response=array( "status"=>false,
                    "error"=>$validation->errors());

         } else{

             $freelancer = Freelancer::where("freelancer_id","=",$request->user_id)->First();

          if($freelancer==null){

            $response=array("status"=>false,
                "error"=>"freelancer profile does not found");

          }else{


            $data["freelancer_id"] = $request->user_id;
            
           unset($data["user_id"]);
          
           $update  = $freelancer->update($data)     ;


            if ($update) {
                $response=array("status"=>true,
                "data"=>$freelancer );
            }else{

                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated");

            }

        }
         }
        return response()->json($response,200);

    }


   

     public function changeFreelancerCV( Request $request )
    {

        if ( $request->file('curriculum_vitae')  == null) {

             $data = $request->all();
             $freelancer = Freelancer::where("freelancer_id","=",$request->user_id)->First();
              $update  = $freelancer->update($data)     ;

               if ($update) {
                $response=array("status"=>true,
                "data"=>$freelancer );
            }else{

                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated");

            }


            
        }else{



            if ($request->file('curriculum_vitae')->isValid()) {
                     $file = Input::file('curriculum_vitae');
                $destinationPath= public_path().'/uploads/freelancer/freelancer_curriculum_vitae';
                $random_name = str_random(10);
                $extension = $file->getClientOriginalExtension();
                $filename=   $request->user_id . '_' . $random_name .'.' .$extension;
                $request->file('curriculum_vitae')->move($destinationPath, $filename) ;

                $data = $request->all();
                 unset( $data["curriculum_vitae"]   );
                $data ['freelancer_curriculum_vitae'] = $filename;
                // dd ( $data );

                $freelancer = Freelancer::where("freelancer_id","=",$request->user_id )->First();
                File::delete($destinationPath . '/' .$freelancer->freelancer_curriculum_vitae);
                  $update  = $freelancer->update($data)     ;

            if ($update) {
                $response=array("status"=>true,
                "data"=>$freelancer );
            }else{

                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated");

            }
        }

            }
                return response()->json($response,201);
    }


    public function changeFreelancerImage( Request $request )
    {

      if ( $request->user_id  == null) {

        $error['code'] = 401;
        $error['message'] = 'you have to enter user_id';
        
         $response=array("status"=>false,
                "error"=> $error);

      }else{

    

        if ( $request->file('image')  == null) {

             $data = $request->all();
             $freelancer = Freelancer::where("freelancer_id","=",$request->user_id)->First();
              $update  = $freelancer->update($data)     ;

               if ($update) {
                $response=array("status"=>true,
                "data"=>$freelancer );
            }else{

                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated");

            }


            
        }else{


            if ($request->file('image')->isValid()) {
                     $file = Input::file('image');
                $destinationPath= public_path().'/uploads/freelancer/images';
                $random_name = '_' . str_random(10);
                $extension = $file->getClientOriginalExtension();
                $filename=   $request->user_id . $random_name .'.' .$extension;
                $request->file('image')->move($destinationPath, $filename) ;

                $data = $request->all();
                $data ['image'] = $filename;

                $freelancer = Freelancer::where("freelancer_id","=",$request->user_id)->First();
                File::delete($destinationPath . '/' .$freelancer->image);
                  $update  = $freelancer->update($data)     ;

            if ($update) {
                $response=array("status"=>true,
                "data"=>$freelancer );
            }else{

                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated");

            }

            }
        }
      }
    
                return response()->json($response,201);
  }



    public function changeOnlyFreelancerImage( Request $request )
    { 

            $uploadedFile = new UploadedFile;

        if ( ! $uploadedFile->validate(  $request->file('image') ) ){


                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated, something went wrong");

        }else{



              $freelancer = Freelancer::where("freelancer_id","=",$request->user_id)->First();
                $destinationPath = public_path().'/uploads/freelancer/images';

                $file = Input::file('image');
                $random_name = str_random(20);
                $extension = $file->getClientOriginalExtension();
                $filename=   $random_name .'.' .$extension;
                $request->file('image')->move($destinationPath, $filename) ;

                $data ['image'] = $filename;

                $freelancer = Freelancer::where("freelancer_id","=",$request->user_id)->First();
                File::delete($destinationPath . '/' .$freelancer->image);
                  $update  = $freelancer->update($data)     ;

            if ($update) {
                $response=array("status"=>true,
                "data"=>$freelancer );
            }else{

                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated");

            }

            
        }
                return response()->json($response,201);
    }




    public function changeOnlyFreelancerImage_original( Request $request )
    {

        if ( $request->file('image')  == null) {

             $freelancer = Freelancer::where("freelancer_id","=",$request->user_id)->First();

               if ($update) {
                $response=array("status"=>true,
                "data"=>$freelancer );
            }else{

                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated");

            }
            
        }else{


            if ($request->file('image')->isValid()) {
                $file = Input::file('image');
                $destinationPath= public_path().'/uploads/freelancer/images';
                $random_name = '_' . str_random(10);
                $extension = $file->getClientOriginalExtension();
                $filename=   $request->user_id . $random_name .'.' .$extension;
                $request->file('image')->move($destinationPath, $filename) ;

                $data ['image'] = $filename;

                $freelancer = Freelancer::where("freelancer_id","=",$request->user_id)->First();
                File::delete($destinationPath . '/' .$freelancer->image);
                  $update  = $freelancer->update($data)     ;

            if ($update) {
                $response=array("status"=>true,
                "data"=>$freelancer );
            }else{

                $response=array("status"=>false,
                "error"=>"freelancer profile can't  be updated");

            }

            }
        }
                return response()->json($response,201);
    }






    public function getFreelancerSkills( $freelancer_id){


        $freelancer=Freelancer::where("freelancer_id","=",$freelancer_id)->First();
        $skills = $freelancer->skills()->get();
        // $skills = $skills->skill_id;
        // unset($skills->pivot);
                $response=array("status"=>true,
                    "data"=>$skills);
            return response()->json($response,200);
           

        }






      public function updateFreelancerSkills(   Request $request    )
      {

        // get all skills from the client request 
        $skills_removed = explode(',', $request->skills_removed);
        $skills_added = explode(',', $request->skills_added);
        // dd($skills_added);
                $freelancer = Freelancer::find( $request->user_id   );

        if ($skills_removed !== []  ) {
            

                foreach ($skills_removed as $skill_removed  ) {
                    $freelancer->skills()->detach($skill_removed);

                }
            }
            // dd($skills_added);

            if ( $skills_added !== [ 0 => ""] ) {

                foreach ($skills_added as $skill_added  ) {

                   $freelancer->skills()->attach($skill_added);

                }

        }

        // $newFreelancerSkills = $this->getFreelancerSkills($request->user_id);


              
                $response=array("status"=>true,
                    "data"=>$skills = $freelancer->skills()->get() );
           
            return response()->json($response,200);

        }

        public function participate()
    {

       if(  Auth::guest()){
            $response=array("status"=>false,
                "error"=>"unauthorized");
        }else{

        $freelancer = Freelancer::find(Auth::user()->user_id);

        return 'your participation is accepted';
        }
      }
     


}