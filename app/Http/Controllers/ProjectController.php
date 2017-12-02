<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Project;
use App\Enterprise;
use App\Challenge;
use App\Freelancer;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $enterprise = Enterprise::find(Auth::user()->user_id);
        $projects = $enterprise->projects_complete_data();
        return view('projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        Project::create($request->all());
        return redirect()->route('project.index')->with('message', 'item has been added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {   

        $enterprise = $project->enterprise()->first();
        $challenges = $project->challenges()->get();
        $interested_freelancer_got_by_id = $project->freelancers()->get()->where('freelancer_id','=', Auth::user()->user_id )->first() ;
        $project->freelancer_interest = empty($interested_freelancer_got_by_id)  ? 0 : 1;

        if (!Auth::guest() ) {
        if( $project->is_owner(  Auth::user()->user_id ) ){

        return view('projects.showForOwner', compact('enterprise', 'project','challenges'));
        }
        }

        return view('projects.show', compact('enterprise', 'project','challenges'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $enterprise = $project->enterprise()->first();
        $challenges = $project->challenges()->get();
        return view('projects.edit', compact('project', 'enterprise', 'challenges'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        // you have to except the enterprise id from being updated
        unset( $request['enterprise_id'] );
        $project->update($request->all());
        return redirect()->route('project.index')->with('message', 'item has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //to correct bugs

        $challenges = $project->challenges()->get()->all(); // an array of object challenge
        dd($challenges );
        
        //verify if no one had participated in this challenge
    //      foreach ($challenges as $challenge  ) {
    //     $chal = $challenge->freelancers()->get() ;
    //     dd($chal);
    // }


        foreach ($challenges as $challenge  ) {

            if ($challenge->freelancers()->get() == [] ) {

                    $project->challenges()->detach(); //relation 1:n between the project and challenges

                    $project->delete();
                    return redirect()->route('project.index')->with('message', 'item has been deleted successfully') ;

                }else{

                    return redirect()->route('project.index')->with('message', 'you can\'t delete this item') ;
                }

            }
            
            return 'stop';

        }



        

        public function getAllProjects(){

            $projects = Project::all();
            foreach ($projects as $project) {

                $enterprise = Enterprise::find($project->enterprise_id)!=null? Enterprise::find($project->enterprise_id):null;

                $project->enterprise = $enterprise->enterprise_name == null ? 'unknown':$enterprise->enterprise_name ;
                $project->logo = '/uploads/enterprise/images/orange.png';
            // array_push($projectt,$project);
            }

            $response=array("status"=>true,
                "data"=>$projects);

            return response()->json($response,200);

        }

        public function getAllProjectsWithInterestAndParticipation( $freelancer_id ){

        $freelancer = Freelancer::find($freelancer_id);
           if($freelancer==null){
            $response=array("status"=>false,
                "error"=>"no freelancer with this id");
            }
            else{

            $projects = Project::paginate(5)->all();
            foreach ($projects as $project) {

                $enterprise = Enterprise::find($project->enterprise_id)!=null? Enterprise::find($project->enterprise_id):null;

                $project->enterprise = $enterprise->enterprise_name == null ? 'unknown':$enterprise->enterprise_name ;
                $project->logo = '/uploads/enterprise/images/orange.png';
                $project->project_image = '/uploads/projects/images/orange.png';
                //
                //  get the number of freelancers interested by this challenge
                //
                $interested_freelancers_number = $project->freelancers()->count();
                $project->interested_number = $interested_freelancers_number;

                //
                //  get the number of freelancers participated in this project = the sum of numbers participation in each challenge of this project
                //
                $project->participation_number = $project->participationNumber();

                //  
                //  get if the freelancer is interested or not by this project
                //
                $interested_freelancer_got_by_id = $project->freelancers()->get()->where('freelancer_id','=', $freelancer_id)->first() ;
                $project->freelancer_interest = empty($interested_freelancer_got_by_id)  ? 0 : 1;
            }

            $response=array("status"=>true,
                "data"=>$projects);
        }
        return response()->json($response,200);

    }

    public function getAllInterestingProjects( $freelancer_id ){

           $freelancer = Freelancer::find($freelancer_id);
           if($freelancer==null){
            $response=array("status"=>false,
                "error"=>"no freelancer with this id");
            }
            else{
            $projects = Project::paginate(5)->all();
            foreach ($projects as $project) {
                $enterprise = Enterprise::find($project->enterprise_id)!=null? Enterprise::find($project->enterprise_id):null;
                $project->enterprise = $enterprise->enterprise_name == null ? 'unknown':$enterprise->enterprise_name ;
                $project->logo = '/uploads/enterprise/images/orange.png';
                $project->project_image = '/uploads/projects/images/orange.png';
                $interested_freelancers_number = $project->freelancers()->count();
                $project->interested_number = $interested_freelancers_number;
                $project->participation_number = $project->participationNumber();
                $interested_freelancer_got_by_id = $project->freelancers()->get()->where('freelancer_id','=', $freelancer_id)->first() ;
                $project->freelancer_interest = empty($interested_freelancer_got_by_id)  ? 0 : 1;
            }
            $response=array("status"=>true,
                "data"=>$projects);
        }
        return response()->json($response,200);
    }


    public function getAllParticipatedInProjects( $freelancer_id ){

           $freelancer = Freelancer::find($freelancer_id);
           if($freelancer==null){
            $response=array("status"=>false,
                "error"=>"no freelancer with this id");
            }
            else{
            $projects = Project::paginate(5)->all();
            foreach ($projects as $project) {
                $enterprise = Enterprise::find($project->enterprise_id)!=null? Enterprise::find($project->enterprise_id):null;
                $project->enterprise = $enterprise->enterprise_name == null ? 'unknown':$enterprise->enterprise_name ;
                $project->logo = '/uploads/enterprise/images/orange.png';
                $project->project_image = '/uploads/projects/images/orange.png';
                $interested_freelancers_number = $project->freelancers()->count();
                $project->interested_number = $interested_freelancers_number;
                $project->participation_number = $project->participationNumber();
                $interested_freelancer_got_by_id = $project->freelancers()->get()->where('freelancer_id','=', $freelancer_id)->first() ;
                $project->freelancer_interest = empty($interested_freelancer_got_by_id)  ? 0 : 1;
            }
            $response=array("status"=>true,
                "data"=>$projects);
        }
        return response()->json($response,200);

    }


    
    public function getAllProjectChallenges( $project_id ){

       $project = Project::where("project_id","=",$project_id)->First();
       if ($project == null) {

        $error['code'] = 404;
        $error['message'] = 'no project with this id';
        $response=array("status"=>false,
            "error"=> $error);
    }else{

                //found all the challenges related to this project and return all the data
        $challenges = $project->challenges()->get();
        foreach ($challenges as $challenge) {
          $challenge->challenge_document = $challenge->challenge_document != null ? '/uploads/enterprise/enterprise_documents/' . $challenge->challenge_document : null ;
        }
        $response=array("status"=>true,
            "data"=>$challenges);

    }
    return response()->json($response,200);
    }

    // public function getInterested( $user_id, $project_id ){

    //    $freelancer = Freelancer::find($user_id);
    //          $freelancer->projects()->attach($project_id);
    //             $data['code'] = 201;
    //             $data['message'] = "interest request accepted";
    //             $response=array("status"=>true,
    //                 "data"=> $data ); 
            

    //     return response()->json($response,200);
    // }

    public function getInterested( $user_id, $project_id ){


       $freelancer = Freelancer::find($user_id);
       if ($freelancer == null) {
            $error['code'] = 404;
        $error['message'] = 'no freelancer with this id';
        $response=array("status"=>false,
            "error"=> $error);
           
       }else{

            $project = Project::find($project_id);
            if ($project ==null) {
                $error['code'] = 404;
                 $error['message'] = 'no project with this id';
                 $response=array("status"=>false,
                "error"=> $error);
            }else{

                $data['code'] = 201;
                $data['message'] = "interest request accepted";
            $freelancer->projects()->attach($project_id);
            $response=array("status"=>true,
                    "data"=> $data ); 
            }
       }
       return response()->json($response,200);

   }

      public function getDisinterested( $user_id, $project_id ){

       
        $freelancer = Freelancer::find($user_id);

         if ($freelancer == null) {
            $error['code'] = 404;
        $error['message'] = 'no freelancer with this id';
        $response=array("status"=>false,
            "error"=> $error);
           
       }else{

             $project = Project::find($project_id);
            if ($project ==null) {
                $error['code'] = 404;
                 $error['message'] = 'no project with this id';
                 $response=array("status"=>false,
                "error"=> $error);
            }else{
       
            $result = $freelancer->projects()->detach($project_id);
                $data['code'] = 201;
                $data['message'] = "disinterest request accepted";
                $response=array("status"=>true,
                    "data"=> $data ); 
                }
            
            }
        return response()->json($response,200);
    }

       public function getInterestedThroughWeb( $project_id ){

        if(Auth::guest()){

            $error['code'] = 401;
        $error['message'] = 'get login first';
        $response=array("status"=>false,
            "error"=> $error);
        }
        else{
            $freelancer = Freelancer::find( Auth::user()->user_id);
            $data['code'] = 201;
            $data['message'] = "interest request accepted";
            $freelancer->projects()->attach($project_id);
            $response=array("status"=>true,
                    "data"=> $data ); 
            
        }
        return response()->json($response,200);
    }
    public function getDisinterestedThroughWeb( $project_id ){

            if(Auth::guest()){

                $error['code'] = 401;
            $error['message'] = 'get login first';
            $response=array("status"=>false,
                "error"=> $error);
            }
            else{
                $freelancer = Freelancer::find( Auth::user()->user_id);
                $data['code'] = 201;
                $data['message'] = "disinterest request accepted";
                $freelancer->projects()->detach($project_id);
                $response=array("status"=>true,
                        "data"=> $data ); 
                
            }
            return response()->json($response,200);
        }

 

     public function getProjectSkills( $project_id ){

           $project = Project::find($project_id);
           if ($project == null) {
              $data['code'] = 404;
                    $data['message'] = "no project with this id";
                    $response=array("status"=>true,
                        "data"=> $data ); 
                    return response()->json($response,404);
           }
               
                $skills = $project->skills()->get();
                    $response=array("status"=>true,
                "data"=>$skills);
                

            return response()->json($response,200);
        }


}
