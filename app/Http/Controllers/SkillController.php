<?php

namespace App\Http\Controllers;

use App\Skill;
use Illuminate\Http\Request;
use App\Http\Requests\SkillRequest;
use App\Freelancer;
use App\User;
use App\Project;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller {
    // public function __construct()
    // {
    // $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $skills = Skill::all();
        return view('skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('skills.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //some validation
        Skill::create($request->all());
        return redirect()->route('skill.index')->with('message', 'item has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill) {

        return view('skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill) {
        return view('skills.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill) {
        $skill->update($request->all());
        return redirect()->route('skill.index')->with('message', 'item has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill) {

        $skill->delete();
        return redirect()->route('skill.index')->with('message', 'item has been deleted successfully');
    }

    public function getAllSkills() {

        $skills = Skill::all();

        $response = array("status" => true,
            "data" => $skills);

        return response()->json($response, 200);
    }


    public function getAllSkillsByName( $skill_name ) {

         try {

        $skills = Skill::all();

        $response = array("status" => true,
            "data" => $skills);

                return response()->json($response, 200);
            
        } catch (\Exception $e) {
            $response = array("status" => false,
                "error" => $e->getMessage());
            return response()->json($response, 200);
        }
    }


    public function searchForFreelancerBySkills($skill_name) {

        try {

            $skill = Skill::where("title", "=", $skill_name)->First();
            if ($skill == null) {
                $response = array("status" => true,
                    "data" => []);
                return response()->json($response, 200);
            }
            $freelancers = $skill->freelancers()->get()->unique('freelancer_id');

            foreach ($freelancers as $freelancer) {

                $freelancer->email = User::findOrFail($freelancer->freelancer_id)->email;
                $freelancer->image = '/uploads/freelancer/images/' . ($freelancer->image == null ? 'flancer.png' : $freelancer->image);
                $freelancer->freelancer_curriculum_vitae = '/uploads/freelancer/freelancer_curriculum_vitae/FLANCER-CV.pdf'; // . $freelancer->freelancer_curriculum_vitae ;
            }
            $response = array("status" => true,
                "data" => $freelancers);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array("status" => false,
                "error" => $e->getMessage());
            return response()->json($response, 200);
        }
    }

    public function addFreelancerSkill($skill_id) {

        if (Auth::guest()) {

            $response = array("status" => false,
                "error" => "unauthorized");
        } else {

            $freelancer = Freelancer::find(Auth::user()->user_id);
            $freelancer->skills()->attach($skill_id);
            $data['code'] = 201;
            $data['message'] = "skill added with success";

            $response = array("status" => true,
                "data" => $data);
        }
        return response()->json($response, 200);
    }

    public function deleteFreelancerSkill($skill_id) {

        if (Auth::guest()) {

            $response = array("status" => false,
                "error" => "unauthorized");
        } else {

            $freelancer = Freelancer::find(Auth::user()->user_id);
            $freelancer->skills()->detach($skill_id);
            $data['code'] = 201;
            $data['message'] = "skill deleted with success";

            $response = array("status" => true,
                "data" => $data);
        }
        return response()->json($response, 200);
    }


    public function addProjectSkill( $project_id, $skill_id) {
        if (Auth::guest()) {
            $response = array("status" => false,
                "error" => "unauthorized");
        } else {
            $project = Project::find($project_id);
            $project->skills()->attach($skill_id);
            $data['code'] = 201;
            $data['message'] = "project skill added with success";
            $response = array("status" => true,
                "data" => $data);
        }
        return response()->json($response, 200);
    }

    public function deleteProjectSkill( $project_id, $skill_id) {

        if (Auth::guest()) {
            $response = array("status" => false,
                "error" => "unauthorized");
        } else {
            $project = Project::find(52);
            $project->skills()->detach($skill_id);
            $data['code'] = 201;
            $data['message'] = "project skill deleted with success";
            $response = array("status" => true,
                "data" => $data);
        }
        return response()->json($response, 200);
    }
}
