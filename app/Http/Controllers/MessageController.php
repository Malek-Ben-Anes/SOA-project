<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
      protected $page = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function getAllMessageWeb()
   {
    if(  Auth::guest()){

      $response=array("status"=>false,
        "error"=>"unauthorized");
      return response()->json($response,401);
    }else{
      $user = User::find( Auth::user()->user_id   );
      $messages = $user->paginatedMessages(3);

      $data = $messages->all();
      $response=array("status"=>true,
        "data"=> $data);
      
      return response()->json($response,200);
      }
    }

  /**
       * Display a listing of the resource.   for mobile
       *
       * @return \Illuminate\Http\Response
       */
  public function getAllMessages($user_id)
  {
    $user = User::find($user_id);
    $messages = $user->paginatedMessages($this->page);
    $data = $messages->all();
    $response=array("status"=>true,
      "data"=> $data);
    return response()->json($response,200);
  }

/**
       * Display a listing of the resource.   for mobile
       *
       * @return \Illuminate\Http\Response
       */
  public function send(Request $request)
  {
    $user = User::find($request->sender_id);
    $user->contact($request->sender_id, $request->receiver_id,  $request->content );
    $response=array("status"=>true,
      "data"=> "message is sended");
    return response()->json($response,200);
  }
}
