<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Enterprise;
use URL;
use App\User;
use App\Notification;
use App\Message;

class HomeController extends Controller
{
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
    public function index()
    {

        
        $projects = Project::paginate(4);
        foreach($projects as $project){
             
           $project->complete_data();

        

        }
        
        return view('home',compact('projects', 'challenges') );
    }
}
