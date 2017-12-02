<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pack;
use App\User;
use App\Feature;
use App\Freelancer;
use App\Enterprise;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

class PackController extends Controller {

    /**
     * Display a listing of the coins resource.
     *
     * @return Response
     */
    public function index() {
        $packs = Pack::all();
        if (Auth::user()->type == "freelancer") {
            $balance = Freelancer::find(Auth::user()->user_id)->coins;
        } else {
            $balance = Enterprise::find(Auth::user()->user_id)->coins;
        }
        return view('packs.index', compact('packs', 'balance'));
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
    public function store(Request $request) {

        $data = ['phone_number' => '+216' . $request->phone_number,
            'service_name' => 'ODCTOUNSI'];

        $response = $this->CallAPI('POST', 'http://odchosting.tn/osc2017/billing/ws/generate_send_otp.php', $data);
        $response = json_decode($response, true);

        if ($response['status'] == false) {
            return back()->with('error', 'phone number is not correct');
            ;
        } else {

            $location = $response["data"]["location"];
            $pack_id = $request->pack_id;
            $phone_number = $request->phone_number;

            return view('packs.show-phone', compact('phone_number', 'pack_id', 'location'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($pack_id) {
        if (Auth::user()->type == "freelancer") {
            $phone_number = Freelancer::find(Auth::user())->first()->phone;
        } else {
            $phone_number = Enterprise::find(Auth::user())->first()->phone;
        }
        return view('packs.show-phone', compact('phone_number', 'pack_id'));
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
     * Display a listing of the resource in Json format.
     *
     * @return Response
     */
    public function getAllPacks() {
        try{ 
        $packs = Pack::all();
        $response = array("status" => true,
                "data" => $packs);
            return response()->json($response, 200);
             } catch (\Exception $e) {
            $response = array("status" => false,
                "error" => $e->getMessage());
            return response()->json($response, 200);
        }
    }

    /**
     * Display a listing of the resource in Json format.
     *
     * @return Response
     */
    public function getAllFeatures() {
        return Feature::all();
    }

    /**
     * Display a listing of the resource in Json format.
     *
     * @return Response
     */
    public function saveTransaction(Request $request) {
        try {
            $user = User::findOrFail($request->user_id);
            // dd(  $user->transactions()->get() );
            $user->transactions()->attach($request->pack_id, $request->all());
            // $user->addCoins();
            $response = array("status" => true,
                "data" => "transaction has been successfully approved");
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array("status" => false,
                "error" => $e->getMessage());
            return response()->json($response, 200);
        }
    }

    /**
     * Display a listing of the resource in Json format.
     *
     * @return Response
     */
    public function getAllTransactions($user_id) {
        try {
            $user = User::findOrFail($user_id);
            $transactions = $user->transactions()->get()->all();
            $features_log = $user->features()->get()->all();
            $array_variabe = [];
            // format the transactions
            foreach ($transactions as $transaction) {
                $transaction->pivot->coins = $transaction->coins;
                $transaction->pivot->type = 'transaction';
                $transaction->pivot->description = null;
                $transaction->pivot->enterprise_name = null;
                array_push($array_variabe, $transaction->pivot);
            }

            // format the features_log
            foreach ($features_log as $feature_log) {
                $feature_log->pivot->coins = $feature_log->price_coins;
                $feature_log->pivot->type = 'features logs';
                array_push($array_variabe, $feature_log->pivot);
            }

            usort($array_variabe, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            $response = array("status" => true,
                "data" => $array_variabe);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array("status" => false,
                "error" => $e->getMessage());
            return response()->json($response, 200);
        }
    }

    // Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

    function CallAPI($method, $url, $data = false) {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    /**
     * get the first api billing web service.
     *
     * @return Response
     */
    public function firstApiWebService(Request $request) {
        // $packs = Pack::all();
        //     return view('packs.index',compact('packs'))->with('message', 'transaction has successfully runned');
        $data = ['phone_number' => '+216' . $request->phone_number,
            'service_name' => 'ODCTOUNSI'];

        $response = $this->CallAPI('POST', 'http://odchosting.tn/osc2017/billing/ws/generate_send_otp.php', $data);
        $response = json_decode($response, true);

        if ($response['status'] == false) {
            return back()->with('error', 'phone number is not correct Or internet connexion problem');
        } else {

            $location = $response["data"]["location"];
            $pack_id = $request->pack_id;
            $phone_number = $request->phone_number;
            return view('packs.show-code', compact('phone_number', 'pack_id', 'location'));
        }
    }

    /**
     * get the second api billing web service.
     *
     * @return Response
     */
    public function secondApiWebService(Request $request) {

        $data1 = ['phone_number' => '+216' . $request->phone_number,
            'service_name' => 'ODCTOUNSI',
            'code_verif' => $request->code_verif,
            'location' => $request->location
        ];
        $response = $this->CallAPI('POST', 'http://odchosting.tn/osc2017/billing/ws/confirm_otp.php', $data1);
        $response = json_decode($response, true);
        if ($response['status'] == false) {

            $location = $request->location;
            $pack_id = $request->pack_id;
            $phone_number = $request->phone_number;
            return view('packs.show-code', compact('phone_number', 'pack_id', 'location'));
            // return 'ok';
            // return back()->with('error', 'verification code is not correct');
        } else {

            $pack = Pack::find($request->pack_id);
            $data2["service_name"] = 'ODCTOUNSI';
            $data2["OrangeApiToken"] = $response["data"]["OrangeApiToken"];
            $data2["user_id"] = Auth::user()->user_id;
            $data2["amount"] = $pack->price;
            $data2["tax_amount"] = 0.00;
            $data2["description"] = "une petite description";
            $data2["project"] = "flanci";
            $user_id = Auth::user()->user_id;
            $pack_id = $request->pack_id;
            $phone_number = $request->phone_number;

            $this->executeTransaction($data2, $pack);
            $packs = Pack::all();
            return redirect()->route('pack.index')->with('message', 'transaction has successfully runned');
        }
    }

    /**
     * get the third api billing web service that carry out the transaction.
     *
     * @return Response
     */
    public function executeTransaction($data, Pack $pack) {
        $response = $this->CallAPI('POST', 'http://odchosting.tn/osc2017/billing/ws/charge_mnt_user.php', $data);
        $response = json_decode($response, true);
        if ($response['status'] == false) {
            return false;
        } else {
            // dd($data);
            $user = User::find(Auth::user()->user_id);
            $user->transactions()->attach($pack->pack_id, ["transactionToken" => $data["OrangeApiToken"]]);

            if (Auth::user()->type == "freelancer") {
                $user = Freelancer::find(Auth::user()->user_id);
            } else {
                $user = Enterprise::find(Auth::user()->user_id);
            }

            $user->update(['coins' => $user->coins + $pack->coins]);
            return true;
        }
    }

    /**
     * get the third api billing web service that carry out the transaction.
     *
     * @return all user transactions
     */
    public function showTransactions() {
        $user = User::find(Auth::user()->user_id);
        $transactions = $user->transactions()->get()->all();
        // dd(count($transactions));  
        $all_transactions = count($transactions);
        $features_log = $user->features()->get()->all();
        $array_variabe = [];
        // format the transactions
        foreach ($transactions as $transaction) {
            $transaction->pivot->coins = $transaction->coins;
            $transaction->pivot->type = 'transaction';
            $transaction->pivot->description = null;
            $transaction->pivot->enterprise_name = null;
            array_push($array_variabe, $transaction->pivot);
        }

        // format the features_log
        foreach ($features_log as $feature_log) {
            $feature_log->pivot->coins = $feature_log->price_coins;
            $feature_log->pivot->type = 'features logs';
            array_push($array_variabe, $feature_log->pivot);
        }

        usort($array_variabe, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        $transactions = $array_variabe;
        $page = Input::get('page', 1);
        $transactions = $this->paginate($transactions, 6, $page);

        return view('packs.index-transactions', compact('transactions', 'all_transactions'));
    }

    public function paginate($items, $perPage, $pageStart = 1) {

        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;

        // Get only the items you need using array_slice
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage, true);
        return new LengthAwarePaginator($itemsForCurrentPage, count($items), $perPage, Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
    }

}
