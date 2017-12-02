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

class FreelancerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const UNLOCK_FREELANCER_COINS = 50;

    public function index() {
        $freelancers = DB::table('freelancers')->paginate(15);
        $users = DB::table('users')->paginate(15);

        // $freelancers->email = $users;
        // dd($freelancers);
        return view('freelancers.index', compact('users', 'freelancers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // $freelancers = Freelancer::all();
        // return view('freelancers.create', compact('freelancers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(FreelancerRequest $request) {
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
    public function show(Freelancer $freelancer) {

        $user = User::find($freelancer->freelancer_id);
        $freelancer->badge = explode(',', $freelancer->badge);
        $freelancer->email = $user->email;
        $freelancer->email = $user->email;
        $skills = $freelancer->skills()->get();
        if (!Auth::guest()) {

        
        if (Auth::user()->type == "enterprise") {
            $user = Enterprise::find(Auth::user()->user_id);
        } else {
            $user = Freelancer::find(Auth::user()->user_id);
        }


        if ($user->is_freelancer_Unlocked($freelancer->freelancer_id) || $user->freelancer_id == $freelancer->freelancer_id) {

            $challenges = $freelancer->challenges()->get();
            $projects = $freelancer->projects()->get();

            return view('freelancers.show', compact('freelancer', 'skills', 'projects', 'challenges'));
        }
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
    public function showInterestedProject() {
        if (Auth::guest()) {
            $response = array("status" => false,
                "error" => "unauthorized");
        } else {

            $freelancer = Freelancer::find(Auth::user()->user_id);
            $projects = $freelancer->projects()->paginate(4);


            // $projects = Project::orderBy('created_at', 'desc')->paginate($this->page);
            // $projects = DB::table('projects') -> orderBy('created_at', 'desc') -> get() -> paginate($this->page);
            $project_number = $projects->count();
            foreach ($projects as $project) {
                $project->complete_data();
                $project->freelancer_interest = 1;
            }

            return view('home', compact('projects', 'challenges', 'project_number'));
        }
        return view('projects.indexDetail', compact('projects'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showParticipatedChallenge() {

        if (Auth::guest()) {
            $response = array("status" => false,
                "error" => "unauthorized");
        } else {

            $freelancer = Freelancer::find(Auth::user()->user_id);
            $challenges = $freelancer->challenges()->orderBy('updated_at', 'desc')->get();
            foreach ($challenges as $challenge) {

                $average = $freelancer->get_average_marks($challenge->challenge_id);
                $challenge->markAverage = $average == -1 ? '-' : number_format($average, 2);
            }
        }
        // dd($challenge);
        return view('challenges.indexWithMark', compact('challenges', 'criterions', 'freelancer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Freelancer $freelancer) {
        $all_skills = Skill::all()->all();
        $freelancer_skills = $freelancer->skills()->get();
        return view('freelancers.edit', compact('freelancer', 'freelancer_skills', 'all_skills'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(FreelancerRequest $request, Freelancer $freelancer) {
        $freelancer->update($request->all());

        $all_skills = Skill::all()->all();
        $freelancer_skills = $freelancer->skills()->get();
        return view('freelancers.edit', compact('freelancer', 'freelancer_skills', 'all_skills'));
    }

    public function changeOnlyFreelancerImageWeb(Request $request) {

        if (Auth::guest()) {
            $response = array("status" => false,
                "error" => "unauthorized");
        } else {

            if ($request->file('image') == null) {

                $response = array("status" => false,
                    "error" => "freelancer profile can't  be updated, image empty");
            } else {
                if ($request->file('image')->isValid()) {
                    $file = Input::file('image');
                    $destinationPath = public_path() . '/uploads/freelancer/images';
                    $random_name = '_' . str_random(10);
                    $extension = $file->getClientOriginalExtension();
                    $filename = $request->user_id . $random_name . '.' . $extension;
                    $request->file('image')->move($destinationPath, $filename);
                    $data ['image'] = $filename;
                    $freelancer = Freelancer::find(Auth::user()->user_id);
                    File::delete($destinationPath . '/' . $freelancer->image);
                    $update = $freelancer->update($data);

                    if ($update) {
                        $response = array("status" => true,
                            "data" => "freelancer image has been updated");
                    } else {

                        $response = array("status" => false,
                            "error" => "freelancer profile can't  be updated");
                    }
                }
            }
        }
        return redirect()->back();
        return response()->json($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Freelancer $freelancer) {

        // user where first return a USER object 
        $user = User::where("user_id", "=", $freelancer->freelancer_id)->First();
        $freelancer->delete();
        $user->delete();
        return redirect()->route('freelancer.index')->with('message', 'item has been deleted successfully');
    }

    public function getAllFreelancers() {
        $freelancers = Freelancer::orderBy('freelancer_id', 'asc')->get();

        $response = array("status" => true,
            "data" => $freelancers);

        return response()->json($response, 200);
    }

    public function getFreelancerById($freelancer_id) {
        try {
            $freelancer = Freelancer::where("freelancer_id", "=", $freelancer_id)->First();
            if ($freelancer == null) {
                $error["code"] = 400;
                $error["message"] = "no freelancer with this id";
                $response = array("status" => false,
                    "error" => $error);
            } else {
                $freelancer->participation_number = $freelancer->participationNumber();
                $freelancer->image = '/uploads/freelancer/images/' . ($freelancer->image == null ? 'flancer.png' : $freelancer->image);
                // $freelancer->badge =  $freelancer->badge==null?  '0' : $freelancer->badge ;
                $freelancer->winning_number = $freelancer->WinningNumber();
                $freelancer->deblocked_number = $freelancer->deblocked_number();
                $response = array("status" => true,
                    "data" => $freelancer);
            }
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    protected function freelancerUpdateValidator(array $data) {
        return Validator::make($data, [

                    'user_id' => 'required',
                    'first_name' => 'required|string|min:3|max:255',
                    'last_name' => 'required|string|min:3|max:255',
                    'phone' => 'required|numeric|min:1000',
                    'address' => 'string|min:4|max:255',
                    'profession' => 'string|min:4|max:255',
                    'description' => 'string|min:4|max:255',
        ]);
    }

    public function changeFreelancerProfile(Request $request) {
        try {

            $data = $request->all();
            $validation = $this->freelancerUpdateValidator($data);
            if ($validation->fails()) {
                $error["code"] = 400;
                $error["message"] = implode(" + ", $validation->errors()->all());
                $response = array("status" => false,
                    "error" => $error);
            } else {
                $freelancer = Freelancer::where("freelancer_id", "=", $request->user_id)->First();
                $user = User::findOrFail($request->user_id);

                if ($freelancer == null) {

                    $response = array("status" => false,
                        "error" => "freelancer profile does not found");
                } else {
                    $data["freelancer_id"] = $request->user_id;
                    unset($data["user_id"]);

                    $update = $freelancer->update($data);
                    $user->update(["username" => $request->first_name]);

                    if ($update) {
                        $response = array("status" => true,
                            "data" => $freelancer);
                    } else {
                        $response = array("status" => false,
                            "error" => "freelancer profile can't  be updated");
                    }
                }
            }
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function changeFreelancerCV(Request $request) {

        if ($request->file('curriculum_vitae') == null) {

            $data = $request->all();
            $freelancer = Freelancer::where("freelancer_id", "=", $request->user_id)->First();
            $update = $freelancer->update($data);

            if ($update) {
                $response = array("status" => true,
                    "data" => $freelancer);
            } else {

                $response = array("status" => false,
                    "error" => "freelancer profile can't  be updated");
            }
        } else {



            if ($request->file('curriculum_vitae')->isValid()) {
                $file = Input::file('curriculum_vitae');
                $destinationPath = public_path() . '/uploads/freelancer/freelancer_curriculum_vitae';
                $random_name = str_random(10);
                $extension = $file->getClientOriginalExtension();
                $filename = $request->user_id . '_' . $random_name . '.' . $extension;
                $request->file('curriculum_vitae')->move($destinationPath, $filename);

                $data = $request->all();
                unset($data["curriculum_vitae"]);
                $data ['freelancer_curriculum_vitae'] = $filename;
                // dd ( $data );

                $freelancer = Freelancer::where("freelancer_id", "=", $request->user_id)->First();
                File::delete($destinationPath . '/' . $freelancer->freelancer_curriculum_vitae);
                $update = $freelancer->update($data);

                if ($update) {
                    $response = array("status" => true,
                        "data" => $freelancer);
                } else {

                    $response = array("status" => false,
                        "error" => "freelancer profile can't  be updated");
                }
            }
        }
        return response()->json($response, 201);
    }

    public function changeFreelancerImage(Request $request) {

        if ($request->user_id == null) {

            $error['code'] = 401;
            $error['message'] = 'you have to enter user_id';

            $response = array("status" => false,
                "error" => $error);
        } else {



            if ($request->file('image') == null) {

                $data = $request->all();
                $freelancer = Freelancer::where("freelancer_id", "=", $request->user_id)->First();
                $update = $freelancer->update($data);

                if ($update) {
                    $response = array("status" => true,
                        "data" => $freelancer);
                } else {

                    $response = array("status" => false,
                        "error" => "freelancer profile can't  be updated");
                }
            } else {


                if ($request->file('image')->isValid()) {
                    $file = Input::file('image');
                    $destinationPath = public_path() . '/uploads/freelancer/images';
                    $random_name = '_' . str_random(10);
                    $extension = $file->getClientOriginalExtension();
                    $filename = $request->user_id . $random_name . '.' . $extension;
                    $request->file('image')->move($destinationPath, $filename);

                    $data = $request->all();
                    $data ['image'] = $filename;

                    $freelancer = Freelancer::where("freelancer_id", "=", $request->user_id)->First();
                    File::delete($destinationPath . '/' . $freelancer->image);
                    $update = $freelancer->update($data);

                    if ($update) {
                        $response = array("status" => true,
                            "data" => $freelancer);
                    } else {

                        $response = array("status" => false,
                            "error" => "freelancer profile can't  be updated");
                    }
                }
            }
        }

        return response()->json($response, 201);
    }

    public function changeOnlyFreelancerImage(Request $request) {

        $uploadedFile = new UploadedFile;

        if (!$uploadedFile->validate($request->file('image'))) {


            $response = array("status" => false,
                "error" => "freelancer profile can't  be updated, something went wrong");
        } else {



            $freelancer = Freelancer::where("freelancer_id", "=", $request->user_id)->First();
            $destinationPath = public_path() . '/uploads/freelancer/images';

            $file = Input::file('image');
            $random_name = str_random(20);
            $extension = $file->getClientOriginalExtension();
            $filename = $random_name . '.' . $extension;
            $request->file('image')->move($destinationPath, $filename);

            $data ['image'] = $filename;

            $freelancer = Freelancer::where("freelancer_id", "=", $request->user_id)->First();
            File::delete($destinationPath . '/' . $freelancer->image);
            $update = $freelancer->update($data);

            if ($update) {
                $response = array("status" => true,
                    "data" => $freelancer);
            } else {

                $response = array("status" => false,
                    "error" => "freelancer profile can't  be updated");
            }
        }
        return response()->json($response, 201);
    }

    public function changeOnlyFreelancerImage_original(Request $request) {

        if ($request->file('image') == null) {

            $freelancer = Freelancer::where("freelancer_id", "=", $request->user_id)->First();

            if ($update) {
                $response = array("status" => true,
                    "data" => $freelancer);
            } else {

                $response = array("status" => false,
                    "error" => "freelancer profile can't  be updated");
            }
        } else {


            if ($request->file('image')->isValid()) {
                $file = Input::file('image');
                $destinationPath = public_path() . '/uploads/freelancer/images';
                $random_name = '_' . str_random(10);
                $extension = $file->getClientOriginalExtension();
                $filename = $request->user_id . $random_name . '.' . $extension;
                $request->file('image')->move($destinationPath, $filename);

                $data ['image'] = $filename;

                $freelancer = Freelancer::where("freelancer_id", "=", $request->user_id)->First();
                File::delete($destinationPath . '/' . $freelancer->image);
                $update = $freelancer->update($data);

                if ($update) {
                    $response = array("status" => true,
                        "data" => $freelancer);
                } else {

                    $response = array("status" => false,
                        "error" => "freelancer profile can't  be updated");
                }
            }
        }
        return response()->json($response, 201);
    }

    public function getFreelancerSkills($freelancer_id) {

        try {
            $freelancer = Freelancer::findOrFail($freelancer_id);
            $skills = $freelancer->skills()->get();
            // $skills = $skills->skill_id;
            // unset($skills->pivot);
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

    public function updateFreelancerSkills(Request $request) {
        try {
            $skills_removed = explode(',', $request->skills_removed);
            $skills_added = explode(',', $request->skills_added);
            $freelancer = Freelancer::findOrFail($request->user_id);
            if ($skills_removed !== []) {
                foreach ($skills_removed as $skill_removed) {
                    $freelancer->skills()->detach($skill_removed);
                }
            }
            if ($skills_added !== [ 0 => ""]) {
                foreach ($skills_added as $skill_added) {
                    $freelancer->skills()->attach($skill_added);
                }
            }
            // $newFreelancerSkills = $this->getFreelancerSkills($request->user_id);
            $response = array("status" => true,
                "data" => $skills = $freelancer->skills()->get());

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function participate() {

        if (Auth::guest()) {
            $response = array("status" => false,
                "error" => "unauthorized");
        } else {

            $freelancer = Freelancer::find(Auth::user()->user_id);

            return 'your participation is accepted';
        }
    }

    public function getFreelancerProfile($freelancer_id, $user_id) {
        try {

            $freelancer = Freelancer::findOrFail($freelancer_id);
            $freelancer->email = User::findOrFail($freelancer_id)->email;
            $freelancer->image = '/uploads/freelancer/images/' . ($freelancer->image == null ? 'flancer.png' : $freelancer->image);
            $freelancer->freelancer_curriculum_vitae = '/uploads/freelancer/freelancer_curriculum_vitae/FLANCER-CV.pdf'; // . $freelancer->freelancer_curriculum_vitae ;
            $freelancer->participation_number = $freelancer->participationNumber();
            $freelancer->winning_number = $freelancer->WinningNumber();
            $freelancer->deblocked_number = $freelancer->deblocked_number();
            $user = Freelancer::findOrFail($user_id);

            $freelancer->unlock = $user->is_freelancer_Unlocked($freelancer_id) == true ? 1 : 0;
            $freelancer->unlock = $user_id == $freelancer_id ? 1 : 0;

            $response = array("status" => true,
                "data" => $freelancer);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function unlockFreelancerProfile($freelancer_id, $user_id) {

            $freelancer = Freelancer::findOrFail($freelancer_id);
            $freelancerUnlocker = Freelancer::findOrFail($user_id);
            $user = User::find($user_id);
            $unlock_transaction_result = $user->setCoinsAmountByUserId(self::UNLOCK_FREELANCER_COINS);
            if ($unlock_transaction_result == true) {
                $freelancerUnlocker->unlockFreelancer($freelancer_id);
                $response = array("status" => true,
                    "data" => ["coins" => ($freelancerUnlocker->coins - self::UNLOCK_FREELANCER_COINS)]);
            }else{
                 $response = array("status" => false,
                    "data" => ["coins" => $freelancerUnlocker->coins]);
            }

            return response()->json($response, 200);
        try {
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function getFreelancersUnlockedProfiles($freelancer_id) {

        try {
            $freelancer = Freelancer::findOrFail($freelancer_id);

            $freelancers_unlocked_profiles = $freelancer->freelancers()->get()->all();


            $response = array("status" => true,
                "data" => $freelancers_unlocked_profiles);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

}
