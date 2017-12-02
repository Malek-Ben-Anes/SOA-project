<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Enterprise;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\EnterpriseRequest;
use App\Http\Requests\EnterpriseUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use File;
use Auth;
use App\Freelancer;

class EnterpriseController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $enterprises = DB::table('enterprises')->paginate(15);
        return view('enterprises.index', compact('enterprises'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexProject($enterprise_id, $project_id = null) {
        $enterprise = Enterprise::where('enterprise_id', '=', $enterprise_id)->first();
        $projects = $enterprise->projects()->get();
        return view('projects.index', compact('enterprise', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return 'create page';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Enterprise $enterprise) {
        // dd($enterprise);
        $projects = $enterprise->projects()->get();
        // $enterprise->logo = ($enterprise->logo == null ? 'logo.png' : $enterprise->logo);
        return view('enterprises.show', compact('enterprise', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Enterprise $enterprise) {
        return view('enterprises.edit', compact('enterprise'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(EnterpriseUpdateRequest $request, Enterprise $enterprise) {

        $enterprise->update($request->all());
        if ($request->file('logo') != null) {
                if ($request->file('logo')->isValid()) {
                    $file = Input::file('logo');
                    $destinationPath = public_path() . '/uploads/enterprise/images';
                    $random_name = '_' . str_random(10);
                    $extension = $file->getClientOriginalExtension();
                    $filename = $request->user_id . $random_name . '.' . $extension;
                    $request->file('logo')->move($destinationPath, $filename);
                    $data ['logo'] = $filename;
                    $enterprise = Enterprise::find(Auth::user()->user_id);
                    File::delete($destinationPath . '/' . $enterprise->logo);
                    $update = $enterprise->update(['logo' => $filename]);
                 }
        }
// dd($request->all());
        // $request->logo != null ? $user->update(['username' => $request->enterprise_name, 'image' => $request->logo]) : null;
        $user = User::find($enterprise->enterprise_id);
        $user->update(['username' => $request->enterprise_name]);
        return view('enterprises.edit', compact('enterprise'))->with('message', 'Your profile has been successfully updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function deblocked($enterprise_id) {
        $enterprise = Enterprise::findOrFail($enterprise_id);
        $freelancers = $enterprise->freelancers()->get()->all();
        return view('freelancers.indexDeblocked', compact('freelancers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
    }

    public function getEnterpriseById($enterprise_id) {
        try {
            $enterprise = enterprise::findOrFail($enterprise_id);
            $user = User::findOrFail($enterprise_id);
            $enterprise->address = ($enterprise->address == null ? 'Tunis, lac 2,  Biwa' : $enterprise->address);
            $enterprise->enterprise_name = ( $enterprise->enterprise_name == null ? 'IBM incorporation' : $enterprise->enterprise_name );
            $enterprise->email = $user->email;
            $enterprise->logo = '/uploads/enterprise/images/' . ($enterprise->logo == null ? 'logo.png' : $enterprise->logo);
            $enterprise->ongoing_challenge = $enterprise->ongoingChallengesNumber();
            $enterprise->challenge_posted = $enterprise->challengesNumber();
            $response = array("status" => true,
                "data" => $enterprise);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function getAllEnterprises() {
        $entreprises = Enterprise::orderBy('enterprise_id', 'asc')->get();


        $response = array("status" => true,
            "data" => $entreprises);

        return response()->json($response, 200);
    }

    public function getEnterpriseByName($enterprise_name) {
        try {
            $enterprise = Enterprise::Where('enterprise_name', '=', $enterprise_name)->first();
            $user = User::findOrFail($enterprise->enterprise_id);
            $enterprise->address = ($enterprise->address == null ? 'Tunis, lac 2,  Biwa' : $enterprise->address);
            $enterprise->enterprise_name = ( $enterprise->enterprise_name == null ? 'IBM incorporation' : $enterprise->enterprise_name );
            $enterprise->email = $user->email;
            $enterprise->logo = '/uploads/enterprise/images/' . ($enterprise->logo == null ? 'logo.png' : $enterprise->logo);
            $enterprise->ongoing_challenge = $enterprise->ongoingChallengesNumber();
            $enterprise->challenge_posted = $enterprise->challengesNumber();
            $response = array("status" => true,
                "data" => $enterprise);
            return response()->json($response, 200);

            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function getAllEnterpriseProjects($enterprise_id, $freelancer_id) {


        $entreprise = Enterprise::findOrFail($enterprise_id);
        $projects = $entreprise->projects()->get();

        foreach ($projects as $project) {
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
        try {
            
        } catch (\Exception $e) {
            $error["code"] = $e->getCode();
            $error["message"] = $e->getMessage();
            $response = array("status" => false,
                "error" => $error);
            return response()->json($response, 200);
        }
    }

    public function unlockFreelancer($freelancer_id) {

        $user = User::find($freelancer_id);
        $result = $user->setCoinsAmount($amount = 50);

        if (Auth::user()->type == "enterprise") {
        $user = Enterprise::find(Auth::user()->user_id);
        }else{
        $user = Freelancer::find(Auth::user()->user_id);
        }


        if ($result == true) {
            $user->unlockFreelancer($freelancer_id);
            return back()->with('message', 'freelancer profile has been deblocked successfully');
        }else{
            return back()->with('message', 'you don\'t have enough coins');
        }
    }

}
