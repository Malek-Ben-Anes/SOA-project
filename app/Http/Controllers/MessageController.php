<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Enterprise;
use App\Freelancer;
use App\Message;

class MessageController extends Controller {

    protected $page = 8;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
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
    public function update(Request $request, $id) {
        //
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllMessageWeb() {
        if (Auth::guest()) {

            $response = array("status" => false,
                "error" => "unauthorized");
            return response()->json($response, 401);
        } else {
            $user = User::find(Auth::user()->user_id);
            $messages = $user->paginatedMessages(3);

            $data = $messages->all();
            $response = array("status" => true,
                "data" => $data);

            return response()->json($response, 200);
        }
    }

    /**
     * Display a listing of the resource.   for mobile
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllMessages($user_id) {
        try {
            $user = User::findOrFail($user_id);
            // $messageNumber = $user->messages()->count();
            $messages = $user->paginatedMessages($this->page);
            // $messages = $messages->all();
            foreach ($messages as $message) {
                $conversationMember = ($message->sender_id == $user_id ? $message->receiver_id : $message->sender_id);
                $user = User::findOrFail($conversationMember);

                if ($user->type == "freelancer") {
                    $freelancer = Freelancer::findOrFail($conversationMember);
                    $message->type = "freelancer";
                    $message->username = $freelancer->pseudonym;
                    $message->image = '/uploads/freelancer/images/' . ($freelancer->image == null ? 'flancer.png' : $freelancer->image);
                } else {
                    $enterprise = Enterprise::findOrFail($conversationMember);
                    $message->type = "enterprise";
                    $message->username = $enterprise->enterprise_name;
                    $message->image = '/uploads/enterprise/images/' . ($enterprise->logo == null ? 'logo.png' : $enterprise->logo);
                }
            }

            // $data= [ "messageNumber" => $messageNumber,
            //         "messages" => $messages   ];
            $response = array("status" => true,
                "data" => $messages);

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
     * Display a listing of the resource.   for mobile
     *
     * @return \Illuminate\Http\Response
     */
    public function getDiscussion($receiver_id, $sender_id) {
        try {
            $user = User::findOrFail($receiver_id);
            // $messageNumber = $user->messages()->count();
            $messages = $user->paginatedDiscussion($this->page, $sender_id);
            $messages = $messages->all();
            foreach ($messages as $message) {
                $user = User::findOrFail($message->sender_id);
                if ($user->type == "freelancer") {
                    $freelancer = Freelancer::findOrFail($message->sender_id);
                    $message->type = "freelancer";
                    $message->username = $freelancer->pseudonym;
                    $message->image = '/uploads/freelancer/images/' . $freelancer->image;
                } else {
                    $enterprise = Enterprise::findOrFail($message->sender_id);
                    $message->type = "enterprise";
                    $message->username = $enterprise->enterprise_name;
                    $message->image = '/uploads/enterprise/images/' . ($enterprise->logo == null ? 'logo.png' : $enterprise->logo);
                }
            }
            $response = array("status" => true,
                "data" => $messages);
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
     * Display a listing of the resource.   for mobile
     *
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request) {
        $user = User::find($request->sender_id);
        $user->contact($request->sender_id, $request->receiver_id, $request->content);
        $response = array("status" => true,
            "data" => "message is sended");
        return response()->json($response, 200);
    }

}
