<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller {

    protected $page = 5;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
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
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllNotificationWeb() {
        try {
            if (Auth::guest()) {

                $response = array("status" => false,
                    "error" => "unauthorized");
                return response()->json($response, 401);
            } else {
                $user = User::find(Auth::user()->user_id);
                $notifications = $user->paginatedNotifications(4);

                $data = $notifications->all();
                $response = array("status" => true,
                    "data" => $data);

                return response()->json($response, 200);
            }
        } catch (\Exception $e) {
            $response = array("status" => false,
                "error" => $e->getMessage());
            return response()->json($response, 200);
        }
    }

    /**
     * Display a listing of the resource.   for mobile
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllNotifications($user_id) {
        try {
            $user = User::find($user_id);
            $notifications = $user->paginatedNotifications($this->page);
            $data = $notifications->all();
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
     * Display a listing of the resource.   for mobile
     *
     * @return \Illuminate\Http\Response
     */
    public function sendNotification(Request $request) {
        // dd($request->all());
        $user = User::find($request->notifier_id);
        // dd($user);
        $user->notify($request->notified_id, $request->notification_id, $request->notifier_id);
        $response = array("status" => true,
            "data" => "notification is sended");
        return response()->json($response, 200);
    }

}
