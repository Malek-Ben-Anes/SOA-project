<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Project;
use App\Enterprise;
use App\Challenge;
use App\Freelancer;
use App\User;
use App\Skill;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProjectController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $enterprise = Enterprise::find(Auth::user()->user_id);
        $projects = $enterprise->projects_complete_data();
        $project_number = $enterprise->projects()->count();
        return view('projects.index', compact('projects', 'project_number'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request) {

        $data = $request->all();
        // verify the validation of the ending date
         $Ending_Date = Carbon::now()->diffInDays( Carbon::parse($request->Ending_Date)) + 1;
         $Ending_Date = ($Ending_Date > 15 ? 15 : $Ending_Date);
         $request->Ending_Date = Carbon::now()->addDays($Ending_Date);
         $data['ending_date'] = Carbon::now()->addDays($Ending_Date)->toDateTimeString();
         $data['open'] = 0;
        // return $request->Ending_Date;
        // return \Carbon\Carbon::now()->addDays(7);
        // dd(  $data);
        Project::create($data);
        // return back();
        return redirect()->route('project.index')->with('message', 'item has been added successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function publish (Request $request) {

        Project::find($request->project_id)->update(["open" => 1]);
        return back()->with('message', 'Project has been published');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project) {

        $project->complete_data();
        $enterprise = $project->enterprise()->first();
        $challenges = $project->challenges()->get();
        foreach ($challenges as $challenge) {
            $challenge->participation_number = $challenge->participationNumber();
        }
        $comments = $project->comments()->get();

        foreach ($comments as $comment) {
            // $comment->created_at = $comment->pivot->created_at->diffInDays(Carbon\Carbon::now());
            if ($comment->type == "freelancer") {
                $comment->username = Freelancer::findOrFail($comment->user_id)->pseudonym;
                $comment->image = '/uploads/freelancer/images/' . 'flancer_off.png';
            } else {
                $comment->image = '/uploads/enterprise/images/' . Enterprise::findOrFail($comment->user_id)->logo;
            }
        }

        $project->freelancer_interest = 0;
        // dd($comments);
        if (!Auth::guest()) {

            $is_freelancer_interested = $project->freelancers()->get()->where('freelancer_id', '=', Auth::user()->user_id)->first();
            $project->freelancer_interest = empty($is_freelancer_interested) ? 0 : 1;

            if ($project->is_owner(Auth::user()->user_id)) {
                return view('projects.showForOwner', compact('enterprise', 'project', 'challenges', 'comments'));
            }
        }

        return view('projects.show', compact('enterprise', 'project', 'challenges', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) {
        $enterprise = $project->enterprise()->first();
        $challenges = $project->challenges()->get();
        foreach ($challenges as $challenge ) {
           $challenge->participation_number = $challenge->participationNumber();
        }
        $skills = $project->skills()->get();
        $all_skills = Skill::all();
        return view('projects.edit', compact('project', 'enterprise', 'challenges', 'skills', 'all_skills'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, Project $project) {
        // you have to except the enterprise id from being updated
        unset($request['enterprise_id']);
        $project->update($request->all());
        return redirect()->route('project.index')->with('message', 'item has been updated successfully');
    }

    public function getAllComments($project_id) {
        try {
            $project = Project::findOrFail($project_id);
            $commentsNumber = $project->comments()->count();
            $projectsCommented = $project->comments()->get()->all();
            $comments = [];
            foreach ($projectsCommented as $projectCommented) {
                $comment = $projectCommented->pivot;
                $user = User::findOrFail($comment->user_id);
                if ($user->type == "freelancer") {
                    $freelancer = Freelancer::findOrFail($comment->user_id);
                    $comment->type = "freelancer";
                    $comment->username = $freelancer->pseudonym;
                    $comment->image = '/uploads/freelancer/images/' . ($freelancer->image == null ? 'flancer.png' : $freelancer->image);
                } else {
                    $enterprise = Enterprise::findOrFail($comment->user_id);
                    $comment->type = "enterprise";
                    $comment->username = $enterprise->enterprise_name;
                    $comment->image = '/uploads/enterprise/images/orange.png';
                }
                unset($comment->project_id);
                array_push($comments, $comment);
            }
            $data = [ "commentsNumber" => $commentsNumber,
                "comments" => $comments];
            $response = array("status" => true,
                "data" => $data);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array("status" => false,
                "error" => $e->getMessage());
            return response()->json($response, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) {
        //to correct bugs

        $challenges = $project->challenges()->get()->all(); // an array of object challenge
        dd($challenges);

        //verify if no one had participated in this challenge
        //      foreach ($challenges as $challenge  ) {
        //     $chal = $challenge->freelancers()->get() ;
        //     dd($chal);
        // }


        foreach ($challenges as $challenge) {

            if ($challenge->freelancers()->get() == []) {

                $project->challenges()->detach(); //relation 1:n between the project and challenges

                $project->delete();
                return redirect()->route('project.index')->with('message', 'item has been deleted successfully');
            } else {

                return redirect()->route('project.index')->with('message', 'you can\'t delete this item');
            }
        }

        return 'stop';
    }

    public function getAllProjects() {
        try {
            $projects = Project::all();
            foreach ($projects as $project) {

                $enterprise = Enterprise::find($project->enterprise_id) != null ? Enterprise::find($project->enterprise_id) : null;

                $project->enterprise = $enterprise->enterprise_name == null ? 'unknown' : $enterprise->enterprise_name;
                $project->logo = '/uploads/enterprise/images/orange.png';
                // array_push($projectt,$project);
            }

            $response = array("status" => true,
                "data" => $projects);

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function getProjectSkills($project_id) {

        try {
            $project = Project::findOrFail($project_id);
            $skills = $project->skills()->get();
            $response = array("status" => true,
                "data" => $skills);

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    // public function complete_project_data(Project $project, Freelancer $freelancer){
    //   $enterprise = Enterprise::findOrFail($project->enterprise_id)!=null? Enterprise::find($project->enterprise_id):null;
    //         $project->enterprise_name = ($enterprise->enterprise_name == null ? 'unknown':$enterprise->enterprise_name );
    //         $project->logo = '/uploads/enterprise/images/'. ($enterprise->logo == null ? 'logo.png':$enterprise->logo);
    //         //  get the number of freelancers interested by this challenge
    //         $interested_freelancers_number = $project->freelancers()->count();
    //         $project->interested_number = $interested_freelancers_number;
    //         //  get the number of freelancers participated in this project = the sum of numbers participation in each challenge of this project
    //         $project->participation_number = $project->participationNumber();
    //         //  get if the freelancer is interested or not by this project
    //         $interested_freelancer_got_by_id = $project->freelancers()->get()->where('freelancer_id','=', $freelancer->freelancer_id)->first() ;
    //         $project->freelancer_interest = empty($interested_freelancer_got_by_id)  ? 0 : 1;
    //         //  get if the freelancer has participated or not by this project
    //         $project->freelancer_participate = $project->is_participated($freelancer->freelancer_id)? 1 : 0;
    //         return $project;
    // }

    public function getAllProjectsWithInterestAndParticipation($freelancer_id) {

        try {
            $freelancer = Freelancer::findOrFail($freelancer_id);
            $projects = Project::paginate(5)->all();
            foreach ($projects as $project) {
                $enterprise = Enterprise::findOrFail($project->enterprise_id) != null ? Enterprise::find($project->enterprise_id) : null;
                $project->enterprise_name = ($enterprise->enterprise_name == null ? 'unknown' : $enterprise->enterprise_name );
                $project->logo = '/uploads/enterprise/images/' . ($enterprise->logo == null ? 'logo.png' : $enterprise->logo);
                //  get the number of freelancers interested by this challenge
                $interested_freelancers_number = $project->freelancers()->count();
                $project->interested_number = $interested_freelancers_number;
                //  get the number of freelancers participated in this project = the sum of numbers participation in each challenge of this project
                $project->participation_number = $project->participationNumber();
                //  get if the freelancer is interested or not by this project
                $interested_freelancer_got_by_id = $project->freelancers()->get()->where('freelancer_id', '=', $freelancer_id)->first();
                $project->freelancer_interest = empty($interested_freelancer_got_by_id) ? 0 : 1;
                //  get if the freelancer has participated or not by this project
                $project->freelancer_participate = $project->is_participated($freelancer_id) ? 1 : 0;
            }

            $response = array("status" => true,
                "data" => $projects);

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    // for mobile
    public function getAllInterestingProjects($freelancer_id) {
        try {
            $freelancer = Freelancer::findOrFail($freelancer_id);
            $projects = $freelancer->projects()->paginate(5)->all();
            foreach ($projects as $project) {
                $enterprise = Enterprise::findOrFail($project->enterprise_id) != null ? Enterprise::find($project->enterprise_id) : null;
                $project->enterprise_name = ($enterprise->enterprise_name == null ? 'unknown' : $enterprise->enterprise_name );
                $project->logo = '/uploads/enterprise/images/' . ($enterprise->logo == null ? 'logo.png' : $enterprise->logo);
                //  get the number of freelancers interested by this challenge
                $interested_freelancers_number = $project->freelancers()->count();
                $project->interested_number = $interested_freelancers_number;
                //  get the number of freelancers participated in this project = the sum of numbers participation in each challenge of this project
                $project->participation_number = $project->participationNumber();
                //  get if the freelancer is interested or not by this project
                $interested_freelancer_got_by_id = $project->freelancers()->get()->where('freelancer_id', '=', $freelancer_id)->first();
                $project->freelancer_interest = empty($interested_freelancer_got_by_id) ? 0 : 1;
                //  get if the freelancer has participated or not by this project
                $project->freelancer_participate = $project->is_participated($freelancer_id) ? 1 : 0;
                unset($project->pivot);
            }
            $response = array("status" => true,
                "data" => $projects);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function getAllParticipatedInProjects($freelancer_id) {

        try {
            $freelancer = Freelancer::findOrFail($freelancer_id);
            $projects = $freelancer->projects()->paginate(5)->all();
            foreach ($projects as $project) {
                $enterprise = Enterprise::findOrFail($project->enterprise_id) != null ? Enterprise::find($project->enterprise_id) : null;
                $project->enterprise_name = ($enterprise->enterprise_name == null ? 'unknown' : $enterprise->enterprise_name );
                $project->logo = '/uploads/enterprise/images/' . ($enterprise->logo == null ? 'logo.png' : $enterprise->logo);
                //  get the number of freelancers interested by this challenge
                $interested_freelancers_number = $project->freelancers()->count();
                $project->interested_number = $interested_freelancers_number;
                //  get the number of freelancers participated in this project = the sum of numbers participation in each challenge of this project
                $project->participation_number = $project->participationNumber();
                //  get if the freelancer is interested or not by this project
                $interested_freelancer_got_by_id = $project->freelancers()->get()->where('freelancer_id', '=', $freelancer_id)->first();
                $project->freelancer_interest = empty($interested_freelancer_got_by_id) ? 0 : 1;
                //  get if the freelancer has participated or not by this project
                $project->freelancer_participate = $project->is_participated($freelancer_id) ? 1 : 0;
                unset($project->pivot);
            }
            $response = array("status" => true,
                "data" => $projects);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function getAllProjectChallenges($project_id) {

        $project = Project::where("project_id", "=", $project_id)->First();
        if ($project == null) {

            $error['code'] = 404;
            $error['message'] = 'no project with this id';
            $response = array("status" => false,
                "error" => $error);
        } else {

            //found all the challenges related to this project and return all the data
            $challenges = $project->challenges()->get();
            foreach ($challenges as $challenge) {
                $challenge->challenge_document = $challenge->challenge_document != null ? '/uploads/enterprise/enterprise_documents/' . $challenge->challenge_document : null;
            }
            $response = array("status" => true,
                "data" => $challenges);
        }
        return response()->json($response, 200);
    }

    public function getInterested($user_id, $project_id) {


        $freelancer = Freelancer::find($user_id);
        if ($freelancer == null) {
            $error['code'] = 404;
            $error['message'] = 'no freelancer with this id';
            $response = array("status" => false,
                "error" => $error);
        } else {

            $project = Project::find($project_id);
            if ($project == null) {
                $error['code'] = 404;
                $error['message'] = 'no project with this id';
                $response = array("status" => false,
                    "error" => $error);
            } else {

                $data['code'] = 201;
                $data['message'] = "interest request accepted";
                $freelancer->projects()->attach($project_id);
                $response = array("status" => true,
                    "data" => $data);
            }
        }
        return response()->json($response, 200);
    }

    public function getDisinterested($user_id, $project_id) {


        $freelancer = Freelancer::find($user_id);

        if ($freelancer == null) {
            $error['code'] = 404;
            $error['message'] = 'no freelancer with this id';
            $response = array("status" => false,
                "error" => $error);
        } else {

            $project = Project::find($project_id);
            if ($project == null) {
                $error['code'] = 404;
                $error['message'] = 'no project with this id';
                $response = array("status" => false,
                    "error" => $error);
            } else {

                $result = $freelancer->projects()->detach($project_id);
                $data['code'] = 201;
                $data['message'] = "disinterest request accepted";
                $response = array("status" => true,
                    "data" => $data);
            }
        }
        return response()->json($response, 200);
    }

    public function getInterestedThroughWeb($project_id) {

        if (Auth::guest()) {

            $error['code'] = 401;
            $error['message'] = 'get login first';
            $response = array("status" => false,
                "error" => $error);
        } else {
            $freelancer = Freelancer::find(Auth::user()->user_id);
            $data['code'] = 201;
            $data['message'] = "interest request accepted";
            $freelancer->projects()->attach($project_id);
            $response = array("status" => true,
                "data" => $data);
        }
        return response()->json($response, 200);
    }

    public function getDisinterestedThroughWeb($project_id) {

        if (Auth::guest()) {

            $error['code'] = 401;
            $error['message'] = 'get login first';
            $response = array("status" => false,
                "error" => $error);
        } else {
            $freelancer = Freelancer::find(Auth::user()->user_id);
            $data['code'] = 201;
            $data['message'] = "disinterest request accepted";
            $freelancer->projects()->detach($project_id);
            $response = array("status" => true,
                "data" => $data);
        }
        return response()->json($response, 200);
    }

    public function getFreelancerParticipation($freelancer_id, $project_id) {

        try {

            $participations = Freelancer::findOrFail($freelancer_id)->challengesWithoutPivot()->where('project_id', '=', $project_id)->get();
            $datas = [];
            $data = new Challenge;
            foreach ($participations as $participation) {

                $data->challenge_id = $participation->challenge_id;
                $data->title = $participation->title;
                $data->paritcipation_url = $participation->pivot->paritcipation_url;
                $data->message = $participation->pivot->message;
                array_push($datas, $data);
            }
            $response = array("status" => true,
                "data" => $datas);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function saveFreelancerParticipation(Request $request) {

        try {

            //to verify that the challenges belongs to the project
            $challenges_id = explode(',', $request->challenges_id);
            foreach ($challenges_id as $challenge_id) {
                Freelancer::findOrFail($request->user_id)->challenges()->detach();
                Freelancer::findOrFail($request->user_id)->challenges()->attach($challenges_id, [
                    'paritcipation_url' => $request->paritcipation_url, 'message' => $request->message]);
            }
            //to verify the attach and the dettach 
            //and the costing for update
            $response = array("status" => true,
                "data" => "your participation has been accepted");
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function getProjectsBySkillName($skill_name, $freelancer_id) {

        try {
            $skill = Skill::where('title', '=', $skill_name)->first();
            if ($skill == null) {
                $response = array("status" => true,
                    "data" => null);
                return response()->json($response, 200);
            }
            $projects = $skill->projects()->get();

            foreach ($projects as $project) {
                unset($project->pivot);
                $enterprise = Enterprise::findOrFail($project->enterprise_id) != null ? Enterprise::find($project->enterprise_id) : null;
                $project->enterprise_name = ($enterprise->enterprise_name == null ? 'enterprise name' : $enterprise->enterprise_name );
                $project->logo = '/uploads/enterprise/images/' . ($enterprise->logo == null ? 'logo.png' : $enterprise->logo);
                //  get the number of freelancers interested by this challenge
                $interested_freelancers_number = $project->freelancers()->count();
                $project->interested_number = $interested_freelancers_number;
                //  get the number of freelancers participated in this project = the sum of numbers participation in each challenge of this project
                $project->participation_number = $project->participationNumber();
                //  get if the freelancer is interested or not by this project
                $interested_freelancer_got_by_id = $project->freelancers()->get()->where('freelancer_id', '=', $freelancer_id)->first();
                $project->freelancer_interest = empty($interested_freelancer_got_by_id) ? 0 : 1;
                //  get if the freelancer has participated or not by this project
                $project->freelancer_participate = $project->is_participated($freelancer_id) ? 1 : 0;
            }

            $response = array("status" => true,
                "data" => $projects);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    /**
     * Sponsorize the project by updating the sponsorize field and notify all correspondant freelancers.
     *
     * @return view with message 
     */

    public function sponsorizeProject(Request $request) {

        $user = User::find(Auth::user()->user_id);
        $project = Project::find($request->project_id);
        $message = '';
        if ($request->sponsorise == 1) {
            // update the project 
            $project->update(["sponsored" => 1]);
            // take 100 C from the enterprise account
            $user->setCoinsAmount($amount = 1);
            $message = 'Your project has been successfully boosted';
        }

        if ($request->notify == 1) {
            // get $freelancers that has the same project skills
            $skills_array = $project->skills()->get()->all();

            //get all freelancers concerned by this project
            $freelancers = $project->getFreelancersBySkillName($skills_array); 

            foreach ($freelancers as $freelancer) {
                // notify all adequat freelancers return how many freelancers has been notified
                $user->notify($freelancer->freelancer_id, 1, $user->user_id);
            }
            // take 50 C from the enterprise account
            $user->setCoinsAmount($amount = 1);
            $message = ($message!= "" ? $message ."<br />" : $message);
            $message = $message . count($freelancers) . ' Freelancer(s) has been notified';
        }
        return back()->with('message', $message);
        return $request->all();
    }

}
