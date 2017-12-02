<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = User::all();
        return $users;
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
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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
    public function update(Request $request, User $user) {
        $user->update($request->all());
        return redirect()->route('task.index')->with('message', 'user has been updated successfully');
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

    public function getUserByMail($email) {
        
    }

    public function getById($id) {
        dd(DB::table('users')->where('user_id', $id));
        return $user->username;
    }

    public function getByMail($email) {
        dd(DB::table('users')->where('email', $email));
        return $user->username;
    }

    /**
     * Show the profile for the given user.
     */
    public function showProfile($id) {
        $user = User::find($id);

        return View::make('user.profile', array('user' => $user));
    }

    /**
     * Send a comment in the project interface.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendComment(Request $request) {
        try {

            User::findOrFail($request->user_id)->comments()->attach($request->project_id, ['content' => $request->content]);
            $response = array("status" => true,
                "data" => "comment is successfully sended");
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array("status" => false,
                "error" => $e->getMessage());
            return response()->json($response, 200);
        }
    }

}
