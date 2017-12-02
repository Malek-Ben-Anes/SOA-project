<?php 

namespace App\Http\Controllers;



use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Enterprise;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\EnterpriseRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use File;
use Auth;
use App\Freelancer;


class EnterpriseController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $enterprises = DB::table('enterprises')->paginate(15);
        return view('enterprises.index', compact('enterprises'));
  }

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexProject( $enterprise_id, $project_id = null )
    {
        $enterprise = Enterprise::where('enterprise_id','=',$enterprise_id)->first();
        $projects =  $enterprise->projects()->get();
        return view('projects.index', compact('enterprise','projects'));
    }


  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return 'create page';
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show( Enterprise $enterprise )
  {
    $projects = $enterprise->projects()->get();
    $enterprise->logo = "orange.png";
     return view('enterprises.show', compact('enterprise','projects'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit( Enterprise $enterprise )
  {
     return view('enterprises.edit', compact('enterprise'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(EnterpriseRequest $request, Enterprise $freelancer)
  {
    $enterprise->update($request->all());

        return view('enterprises.edit', compact('enterprise'));

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function deblocked( $enterprise_id )
  {
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
  public function destroy($id)
  {
    
  }

   public function getEnterpriseById($enterprise_id)
    {
        $enterprise = enterprise::where("enterprise_id","=",$enterprise_id)->First();
        if($enterprise==null){
           $error['code'] = 404;
          $error['message'] = "There are no entreprises";   
            $response=array("status"=>false,
                "error"=>$error);
        }
        else{
            $response=array("status"=>true,
                "data"=>$enterprise );
        }
        return response()->json($response,200);
    }

  public function getAllEnterprises(){
        $entreprises = Enterprise::orderBy('enterprise_id', 'asc')->get();

       
            $response=array("status"=>true,
                "data"=>$entreprises);
        
        return response()->json($response,200);
    }

  public function unlockFreelancer($freelancer_id){
          $entreprise = Enterprise::find(Auth::user()->user_id);
          $entreprise->unlockFreelancer($freelancer_id);
          return back()->with('message', 'freelancer profile has been deblocked successfully');
        
      }

    
     
  
}

