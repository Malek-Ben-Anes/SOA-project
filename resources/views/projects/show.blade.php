@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading"><h2>{{ $project->title }} </h2></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-offset-10 col-md-2">
                            @if (Auth::guest())

                            <button class="register btn btn-default">Interested</button>

                            @elseif (Auth::user()->type    == "freelancer" )
                            {{  Form::button('interested',['onClick'=>'getInterested('.
                            $project->project_id  .')', 'id' => 'interest-' . $project->project_id, 'class' => $project->freelancer_interest == 1 ? 'btn btn-success':'btn btn-default'])  }}
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <p>  {{ $project->description }}</p>
                            <div>
                                @foreach ($project->skills as $skill)
                                <button type="button" class="btn btn-default btn-sm"> {{ $skill->title }} </button>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <hr />
                        <div class="col-md-3">
                            @if ($project->open == 1)
                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>remaining time: {{  $project->ending_date }}
                            @else
                            <span class="text-danger"> Finished</span>
                            @endif
                        </div>
                        <div class="col-md-2">budget {{ $project->budget !=null? $project->budget :'xxxxx' }}  </div>
                        <div class="col-md-3">{{ $project->interested_number }} interests  </div>
                        <div class="col-md-3">{{ $project->participation_number }} participations </div>

                    </div>
                </div>
            </div>

            <h2> list of challenges ({{ count($challenges) }} Challenges)</h2>
            @foreach ($challenges as $challenge)
            <div class="panel panel-default">
                <div class="panel-heading"><h4>{{  $challenge->title  }}</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-10">
                            @if ( Auth::guest() )
                            <button class="register btn btn-default">participate</button>
                            @elseif ( Auth::user()->type    !== "enterprise" )
                            {{ link_to_route('challenge.upload','participate', ['challenge_id' => $challenge->challenge_id], ['class' => 'btn btn-primary'] )}}
                            @endif
                        </div>
                    </div>
                    {{ $project->challenge_id }}
                    {{   $challenge->description   }} 
                    <br /> 

                </div>
            </div>
            @endforeach



        </div>
    </div>
    @include('projects.blog')
</div>
@endsection
