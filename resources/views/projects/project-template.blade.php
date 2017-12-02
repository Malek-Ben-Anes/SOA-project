<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-md-12" >
                <a href="#" class="thumbnail" >
                    <img src="{{ $project->logo }}" alt="enterprise logo">
                </a>
            </div>
            <div class="col-md-10" >
                {{  $project->created_at }}
            </div>
                @if ($project->sponsored == 1)
            <div class="col-md-2" >
                @else
            <div class="col-md-offset-2 col-md-2">
                @endif
                @if (Auth::guest())

                <button class="register btn btn-default">Interested</button>
                @else
                @if (Auth::user()->type    == "freelancer" )
                {{  Form::button('interested',['onClick'=>'getInterested('.
                $project->project_id  .')', 'id' => 'interest-' . $project->project_id, 'class' => $project->freelancer_interest == 1 ? 'btn btn-success':'btn btn-default'])  }}
                @elseif (Auth::user()->type    == "enterprise" && Auth::user()->user_id == $project->enterprise_id)
                {{ link_to_route('project.edit','Update', [$project->project_id], ['class' => 'btn btn-primary']) }}
                @endif
                @endif

            </div>  
        </div>
        <br>
        <div class="row">

            <div class="col-xs-12 col-md-12" >
                   <h5>{{ link_to_route('project.show',  $project->title, [$project->project_id]) }}</h5>
                <div >
                    {{ $project->description }}
                </div>
                <br />
                <div>
                    @foreach ($project->skills as $skill)
                    <button type="button" class="btn btn-default btn-sm"> {{ $skill->title }} </button>
                    @endforeach

                </div>
            </div>
        </div>
        <hr />
        <div class="col-md-3">
            @if ($project->open == 1)

                @if ( \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($project->ending_date)))
            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;&nbsp;remaining &nbsp; 
            {{ \Carbon\Carbon::now()->diffInDays( \Carbon\Carbon::parse($project->ending_date)) }} day(s)<br />
                @else
                    <span class="text-danger"> Finished</span>
                @endif
            @else
            <span class="text-danger"> Finished</span>
            @endif
        </div>
        <div class="col-md-3">budget {{ $project->budget !=null? $project->budget :'xxxxx' }}  </div>
        <div class="col-md-3">{{ $project->interested_number }} interests  </div>
        <div class="col-md-3">{{ $project->participation_number }} participations </div>
    </div>
</div>
