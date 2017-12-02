@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
             @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading"><h2> {{ $project->project_id }} {{ $project->title }} </h2></div>
                    





                    <div class="panel-body">
                    <div class="row">
                            @if (Auth::guest())
                        {{  Form::button('interested',['onClick'=>'getInterested('.
                         $project->project_id  .')', 'id' => 'interest-' . $project->project_id, 'class' => 'btn btn-default'])}} 
                         @elseif (Auth::user()->type    == "freelancer" )
                         {{  Form::button('interested',['onClick'=>'getInterested('.
                         $project->project_id  .')', 'id' => 'interest-' . $project->project_id, 'class' => $project->freelancer_interest == 1 ? 'btn btn-success':'btn btn-default'])  }}
                        @endif
                    </div>
                  <p>  {{ $project->description }}</p>
                  
                    here we put project details
                   </div>
                </div>
                
                <h2> list of challenges </h2>
                @foreach ($challenges as $challenge)
                <div class="panel panel-default">
                    <div class="panel-body">
                    {{ link_to_route('challenge.show', $challenge->title , [$challenge->challenge_id]) }}
                    {{ $project->challenge_id }}
                    {{ $project->description }}
                    <br /><br />
                    
                        {{   $challenge->challenge_id   }} {{   $challenge->title   }} 
                        <br /> 
                        
                   </div>
                </div>

                @endforeach
                


            </div>
        </div>
    </div>
@endsection
