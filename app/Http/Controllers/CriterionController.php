<?php

namespace App\Http\Controllers;

use App\Criterion;
use Illuminate\Http\Request;
use App\Http\Requests\CriterionRequest;
use Illuminate\Support\Facades\Auth;
use App\Freelancer;
use App\Challenge;

class CriterionController extends Controller
{
   
   // public function __construct()
    // {
    // $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $criterions = Criterion::all();
        return view('criterions.index',compact('criterions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('criterions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request)
    {
        //some validation
        Criterion::create($request->all());
        return redirect()->route('criterion.index')->with('message', 'item has been added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Criterion $criterion)
    {

        return view('criterions.show', compact('criterion'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByChallenge($challenge_id)
    {

         if(  Auth::guest()){
            $response=array("status"=>false,
                "error"=>"unauthorized");
        }else{

        $freelancer = Freelancer::find(Auth::user()->user_id);
        $criterions =$freelancer->criterions()->where('challenge_id','=',$challenge_id)->get() ;
        return view('criterions.indexWithMark', compact('criterions'));
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Criterion $criterion)
    {
                return view('criterions.edit', compact('criterion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Criterion $criterion)
    {
        $criterion->update($request->all());
        return redirect()->route('criterion.index')->with('message', 'item has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criterion $criterion)
    {

       $criterion->delete();
        return redirect()->route('criterion.index')->with('message', 'item has been deleted successfully') ;
    }


    public function getAllCriterions(){

    	$criterions = Criterion::all();
              
                $response=array("status"=>true,
                    "data"=>$criterions);
           
            return response()->json($response,200);

    }

    public function searchForFreelancerByCriterions(    $criterion_name     ){

        $criterion = Criterion::where("title","=",$criterion_name)->First();
        $freelancers = $criterion->freelancers()->get()->unique('freelancer_id') ;
                $response=array("status"=>true,
                    "data"=>$freelancers);
            return response()->json($response,200);

    }



	



}

