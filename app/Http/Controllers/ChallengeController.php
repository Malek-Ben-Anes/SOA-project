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

class ChallengeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $challenges = Challenge::all();
        // dd($challenges);
        return view('challenges.index', compact('challenges'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showChallengesSkills($skill_name) {
        //give all the challenges that require a skill given by its name

        $skill = Skill::where('title', '=', $skill_name)->get()->first();
        // $challenges = $skill->challenges()->get();
        //
        //
        //
        //
        $challenges = Challenge::all();
        // dd($challenges);
        return view('challenges.index', compact('challenges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('challenges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChallengeRequest $request) {
        // dd($request->all());
        $challenge = Challenge::create($request->all());
        return redirect()->route('challenge.edit', $challenge->challenge_id)->with('message', 'challenge has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge) {   
        // if the user connectec not the enterprise challenge poster 
        // $challenge = Challenge::find($request->challenge_id);
        if (!Auth::guest() && Auth::user()->type == "enterprise") {

            if ($challenge->is_owner(Auth::user()->user_id)) {

                $challenge->participation_number = $challenge->participationNumber();
                $participations = $challenge->participations();
                // dd($participations);
                return view('challenges.showForOwner', compact('challenge', 'participations'));
            }
        }
        // return 'ok';
        // $participations = $challenge->participations();
        return view('challenges.upload-first-time', compact('challenge'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $challenge
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge) {
        return view('challenges.edit', compact('challenge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $challenge
     * @return \Illuminate\Http\Response
     */
    public function update(ChallengeUpdateRequest $request, Challenge $challenge) {
        // dd($request);
        $challenge->update($request->all());
        return back()->with('message', 'Challenge has been successfully updated ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $challenge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge) {
        if ($challenge->is_destroyable()) {
            $challenge->delete();
            return back()->with('message', 'item has been deleted successfully');
        }
        return back()->with('message', 'you can\'t destroy this challenge');
    }

    public function getAllChallenges() {

        $challenges = Challenge::all();
        foreach ($challenges as $challenge) {
            $challenge->challenge_document = $challenge->challenge_document != null ? '/uploads/enterprise/enterprise_documents/' . $challenge->challenge_document : null;
        }
        $response = array("status" => true,
            "data" => $challenges);

        return response()->json($response, 200);
    }

    public function upload(UploadRequest $request) {

        if (Auth::guest()) {
            return 'you are not authorized';
        } else {

            $uploadedFile = new UploadedFile;
            if ($request->file('attach_document') == null) {

                $freelancer = Freelancer::find(Auth::user()->user_id);
                //     $freelancer->challenges()->detach($request->challenge_id);
                // $freelancer->challenges()->attach($request->challenge_id ,['message' => $request->message, 'paritcipation_url' => $request->paritcipation_url]);
                $freelancer->challenges()->updateExistingPivot($request->challenge_id, ['message' => $request->message, 'paritcipation_url' => $request->paritcipation_url]);
                return back()->with('message', 'your participation is accepted ');
            } else {
                // return 'start upload'; 
                $freelancer = Freelancer::find(Auth::user()->user_id);
                $destinationPath = public_path() . '/uploads/projects/challenges/freelancersWork';
                $file = Input::file('attach_document');
                $random_name = str_random(20);
                $extension = $file->getClientOriginalExtension();
                $filename = 'freelancersWork-' . $random_name . '.' . $extension;
                $request->file('attach_document')->move($destinationPath, $filename);
                $data ['attach_document'] = $filename;

                $old_document = $freelancer->challenges()->where('challenge_freelancer_participation.challenge_id', '=', $request->challenge_id)->first()->pivot->document;
                File::delete($destinationPath . '/' . $old_document);

                // $participation->pivot->message;
                // $freelancer->challenges()->detach($request->challenge_id);
                // $freelancer->challenges()->attach($request->challenge_id ,['message' => $request->message, 'document' => $filename, 'paritcipation_url' => $request->paritcipation_url]);
                $freelancer->challenges()->updateExistingPivot($request->challenge_id, ['message' => $request->message, 'document' => $filename, 'paritcipation_url' => $request->paritcipation_url]);

                return back()->with('message', 'your participation is accepted ');
            }
        }
    }

    public function showParticipation(Challenge $challenge_id) {
        // dd($challenge_id);

        if (Auth::guest()) {

            return 'you are not log in';
        } else {



            // $participation = 
            // return $challenge_id;$challenge_id
            // return 'start';


            return view('challenges.upload'); //, compact('challenge_id'));
        }
    }

}
