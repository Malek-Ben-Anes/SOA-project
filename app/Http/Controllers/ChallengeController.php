<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ChallengeRequest;
use App\Http\Requests\UploadRequest;
use App\Http\Requests\ChallengeUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use File;
use URL;
use App\Freelancer;
use App\UploadedFile;
use App\Challenge;
use App\Enterprise;
use App\Skill;

class ChallengeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $challenges = Challenge::all();
        // dd($challenges);
        return view('challenges.index',compact('challenges'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showChallengesSkills( $skill_name )
    {
        //give all the challenges that require a skill given by its name
        
        $skill = Skill::where('title','=',$skill_name)->get()->first();
        // $challenges = $skill->challenges()->get();
        //
        //
        //
        //
        $challenges = Challenge::all();
        // dd($challenges);
        return view('challenges.index',compact('challenges'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('challenges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChallengeRequest $request)
    {
        // dd($request->all());
        $challenge = Challenge::create($request->all());
        // dd($challenge);
        return redirect()->route('project.show', ['project_id' => $request->project_id])->with('message', 'item has been added successfully');
        return redirect()->route('challenge.index')->with('message', 'challenge has been added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge)
    {   // if the user connectec not the enterprise challenge poster 

        if (!Auth::guest() ) {
            if (  $challenge->is_owner(Auth::user()->user_id) ) {

                $participations = $challenge->participations();
                // dd($participations);
                return view('challenges.showForOwner', compact('challenge','participations'));
            }
        }
        // dd($challenge);
        return view('challenges.show', compact('challenge'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge)
    {
        return view('challenges.edit', compact('challenge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChallengeUpdateRequest $request, Challenge $challenge)
    {
        $challenge->update($request->all());
        return redirect()->route('challenge.index')->with('message', 'item has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge)
    {
        if ($challenge->is_destroyable()) {
            return redirect()->route('challenge.index')->with('message', 'you can\'t destroy this challenge, Freelancers have participated in ') ;
        }
       // $challenge->delete();
        return redirect()->route('challenge.index')->with('message', 'item has been deleted successfully') ;
    }

    public function getAllChallenges(){

        $challenges = Challenge::all();
        foreach ($challenges as $challenge) {
          $challenge->challenge_document = $challenge->challenge_document != null ? '/uploads/enterprise/enterprise_documents/' . $challenge->challenge_document : null ;
      }
      $response=array("status"=>true,
        "data"=>$challenges);

      return response()->json($response,200);

  }

  public function upload (UploadRequest $request)
  {

   $uploadedFile = new UploadedFile;
   if ( ! $uploadedFile->validate(  $request->file('attach_document') ) ){

    return view('challenges.upload')->with('message', 'your work has been uploaded successfully');

}else{

 if(  Auth::guest()){
    
   return 'you are not log in'; 
}else{

         // return 'start upload'; 
    $freelancer = Freelancer::find(Auth::user()->user_id);

    $destinationPath = public_path().'/uploads/projects/challenges/freelancersWork';
    $file = Input::file('attach_document');
    $random_name = str_random(20);
    $extension = $file->getClientOriginalExtension();
    $filename=   'aaaaaa' . $random_name .'.' .$extension;
    $request->file('attach_document')->move($destinationPath, $filename) ;
    $data ['attach_document'] = $filename;

                File::delete($destinationPath . '/' .$freelancer->image); // delete the true one 
                $challenge_id = 2;
                // $participation = $freelancer->challenges($challenge_id)->first()->pivot->message;//($challenge_id)->pivot->document);

                // dd($participation );
                // $participation->pivot->message;
                $freelancer->challenges()->detach($challenge_id);
                $freelancer->challenges()->attach($challenge_id ,['message' => $request->message, 'document' => $filename]);
                // return 'file uploaded';  User::find(1)->roles()->updateExistingPivot($roleId, $attributes);
                return view('challenges.upload')->with('message', 'your work has been uploaded successfully');
                
                
            }

        } return 'error';
    }

    public function showParticipation(Challenge $challenge_id)
    {
        // dd($challenge_id);

        if(  Auth::guest()){
    
            return 'you are not log in'; 
        }else{



        // $participation = 
        // return $challenge_id;$challenge_id
        // return 'start';
        
    
        return view('challenges.upload');//, compact('challenge_id'));
    }
    }

    

}

