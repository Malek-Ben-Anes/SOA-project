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

class ParticipationController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadRequest $request) {

        if (Auth::guest()) {
            return 'you are not authorized';
        } else {

            $uploadedFile = new UploadedFile;
            if ($request->file('attach_document') == null) {

                $freelancer = Freelancer::find(Auth::user()->user_id);
                $freelancer->challenges()->attach($request->challenge_id, ['message' => $request->message, 'paritcipation_url' => $request->paritcipation_url]);
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

                $old_document = $freelancer->challenges()->where('challenge_freelancer_participation.challenge_id', '=', $request->challenge_id)->first();
                if ($old_document != null) {
                    $old_document = $old_document->pivot->document;
                    File::delete($destinationPath . '/' . $old_document);
                }
                $freelancer->challenges()->attach($request->challenge_id, ['message' => $request->message, 'document' => $filename, 'paritcipation_url' => $request->paritcipation_url]);
                return back()->with('message', 'your participation is accepted ');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($challenge_id, $participaton_id) {

        $challenge = Challenge::find($challenge_id);
        $participation = $challenge->participation($participaton_id);
        $freelancer = Freelancer::find($participation->freelancer_id);
        // $criterions =$challenge->criterions()->get();
        // foreach ($criterions as $criterion) {
        //     # code...
        // }
            $criterions = $freelancer->criterions()->where('challenge_id', '=', $challenge_id)->get();
        if (!Auth::guest() && Auth::user()->type == "freelancer") {

            return view('challenges.upload', compact('challenge', 'participation', 'criterions'));
        }
        $criterions = ($criterions->all() == [] ? $criterions = $challenge->criterions()->get() : $criterions);
        foreach ($criterions as $criterion ) {
            // $criterion->pivot->mark = 0;
            // dd($criterion);
        }
        return view('participations.consult', compact('challenge', 'participation', 'criterions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $participation_id) {
        // $freelancer = Freelancer::find(Auth::user()->user_id);
        $freelancer = Freelancer::find($request->freelancer_id);
        $criterions_to_change = [];
        foreach ($request->all() as $key => $mark) {
            if (is_numeric($key)) {
                $criterions_to_change[$key] = $mark;
            }
        }

        //remove existing evaluations in this challenge for this user in database
        foreach ($criterions_to_change as $criterion_to_change => $value) {
            // $criterion = $freelancer->criterions()->where('freelancer_criterion_evaluation.criterion_id',  $value )->first();
            //      if ($criterion != null) {
            //     }
            $freelancer->criterions()->detach($criterion_to_change);
        }

        //save of new evaluations in this challenge for this user in database
        foreach ($criterions_to_change as $criterion_to_change => $value) {
            $freelancer->criterions()->withTimestamps()->attach($criterion_to_change, ['mark' => $value]);
        }
        return back()->with('message', 'Mark has been successfully created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
