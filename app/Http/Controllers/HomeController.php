<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Enterprise;
use URL;
use DB;
use App\User;
use App\Skill;
use App\Notification;
use App\Message;

class HomeController extends Controller {

    protected $page = 6;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $projects = Project::where('open', 1)->orderBy('sponsored', 'desc')->orderBy('created_at', 'desc')->paginate($this->page);
        // $projects = DB::table('projects') -> orderBy('created_at', 'desc') -> get() -> paginate($this->page);
        $project_number = Project::all()->count();
        foreach ($projects as $project) {
            $project->complete_data();
        }

        return view('home', compact('projects', 'challenges', 'project_number'));
    }

    public function search(Request $request) {

        $skill = Skill::where('title', '=', $request->skill)->first();
        if ($skill != null) {

            $projects = $skill->projects()->paginate($this->page);


            $project_number = $projects->count();
            foreach ($projects as $project) {
                $project->complete_data();
            }
            return view('home', compact('projects', 'challenges', 'project_number'));
        } else {

            $projects = [];
            $challenges = [];
            $project_number = 0;
            return view('home', compact('projects', 'challenges', 'project_number'));
        }
    }

}
