@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <input type="text" name="search" placeholder="search on">

            </div>
            <div class="panel panel-default">
                <div class="panel-heading">All offers | Offer by Skill | Offer for my profile</div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <input type="text" name="search" placeholder="search on">

            </div>
            <div class="panel panel-default">
                <div class="panel-heading">218 offers</div>
            </div>

            @foreach ($projects as $project)
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-xs-6 col-md-2" >
                            <a href="#" class="thumbnail" style="width:88px;height:88px;">
                                <img src="{{ $project->logo }}" alt="enterprise logo">
                            </a>
                        </div>
                        <div class="col-md-3" >{{ link_to_route('enterprise.show',  $project->enterprise_name, [$project->enterprise_id]) }}
                            <p>{{ link_to_route('project.show',  $project->title, [$project->project_id]) }}</p>
                            {{ $project->duration }}
                        </div>
                        <div class="col-md-2 col-md-offset-5" >
                            {{-- verify interested --}}
                            {{-- ('/get-interested/{freelancer_id}/project/{project_id}','ProjectController@getInterested') --}}

                            @if (Auth::guest())
                            {{  Form::button('interested',['onClick'=>'getInterested('.
                            $project->project_id  .')', 'id' => 'interest-' . $project->project_id, 'class' => 'btn btn-default'])}} 
                            @else
                            {{  Form::button('interested',['onClick'=>'getInterested('.
                            $project->project_id  .')', 'id' => 'interest-' . $project->project_id, 'class' => $project->freelancer_interest == 1 ? 'btn btn-success':'btn btn-default'])  }}
                            @endif


                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-10" >
                            {{ link_to_route('project.show', 'learn more >', [$project->project_id]) }}
                        </div>

                        <div class="col-xs-6 col-md-8" >
                            <div >
                                {{ $project->description }}
                            </div>
                            <div>
                                @foreach ($project->skills as $skill)
                                <button type="button" class="btn btn-default btn-sm"> {{ $skill->title }} </button>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <hr />
                    {{-- <div class="col-md-3"><span class="glyphicon glyphicon-stop" aria-hidden="true"></span> {{  $project->created_at->toDateString() }}</div> --}}
                    <div class="col-md-3">{{ $project->interested_number }} interests  </div>
                    <div class="col-md-4">{{ $project->interested_number }} participations </div>
                    <div class="col-md-2">open  </div>



                </div>
            </div>
            @endforeach
            {{ $projects->links() }}
        </div>
    </div>
</div>
@endsection
