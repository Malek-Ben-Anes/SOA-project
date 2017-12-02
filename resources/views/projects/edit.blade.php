@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-success">{!! Session::get('message') !!}</div>
            @endif
            <div class="form-group">
                @if (count($challenges) == 0)
                <button type="button" class="sponsorise btn btn-warning btn-sm"> Boost Project </button>
                    {!! Form::button('Publish Project', ['type' => 'submit', 'class' => 'btn btn-basic', 'disabled']) !!} 
                @else
                {!! Form::model($project,['route' => ['project.publish', $project->project_id], 'method' => 'PUT' ])  !!}
                {{ Form::hidden('open', 1 ) }}
                {{ Form::hidden('project_id', $project->project_id ) }}
                <button type="button" class="sponsorise btn btn-warning btn-sm"> Boost Project </button>
                {!! Form::button('Publish Project', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                {!! Form::close() !!}
                @endif
            </div>
            <div class="panel panel-default">
                @if ( count( $errors ) > 0 )
                <ul class="aler alert-danger">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="panel-heading">Update project</div>
                <div class="panel-body">
                    {!! Form::model($project,['route' => ['project.update', $project->project_id], 'method' => 'PUT' ])  !!}
                    <div class="form-group">
                        {!! Form::label('title', 'Enter Title') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                    @if ($project->open == 1)

                    @else
                    <div class="form-group">
                        {{ Form::checkbox('sponsored') }} 
                        {!! Form::label('sponsored', 'will you sponsorise this project with 20 FC') !!}
                    </div>
                    @endif
                    <div class="form-group">
                        {!! Form::label('budget', 'Enter Project Budget') !!}
                        {!! Form::number('budget', null, array('class' => 'form-control','step'=>'any')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('starting_date', 'Your project will start in') !!}
                        {{ Form::date('starting_date',  Carbon\Carbon::now()->format('Y-m-d')  , ['class' => 'form-control', 'disabled']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('Ending_Date', 'Project ending date (duration Max is 15 days) ') !!}
                        {{ Form::date('Ending_Date',  \Carbon\Carbon::parse($project->ending_date)->format('Y-m-d')  , ['class' => 'form-control', 'disabled']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {!! Form::label('Ending_Hour', null) !!}
                        {!! Form::selectRange('hour', 0, 23 , Carbon\Carbon::now()->format('H') , ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group col-md-3">
                        {!! Form::label('Ending_Minute', null) !!}
                        {!! Form::selectYear('year',0, 59, Carbon\Carbon::now()->format('i') , ['class' => 'form-control', 'disabled']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Enter description') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- project skills -->

            <div class="panel panel-default">
                <div class="panel-heading">Skills</div>

                <div class="panel-body">

                    <div class="form-group" id="project-skill-group">
                        {!! Form::Label('skill', 'project skills :') !!}
                        @foreach ($skills as $skill)
                        {{  Form::button($skill->title,['onClick'=>'updateProjectskill('.
                        $skill->skill_id . ',' . $project->project_id .')', 'id' => 'skill-' . $skill->skill_id, 'class' => 'btn btn-success'])  }}
                        @endforeach
                        <br>
                    </div>

                    <div class="form-group">
                        {!! Form::Label('skill', 'choose a project skills :') !!}
                        <select id="select-value" name="skill"  class="btn btn-default" >
                            @foreach ($all_skills as $skill)
                            <option value="{{  $skill->skill_id  }}">{{  $skill->title  }}</option>
                            @endforeach
                        </select>
                        <button type="submit" onclick="addProjectskill( document.getElementById('select-value').value,  document.getElementById('select-value').options[document.getElementById('select-value').selectedIndex].text, {{ $project->project_id }})" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </div>



            <!--// project skills -->

            <div class="panel panel-default">
                <div class="panel-heading">list of challenges ({{ count($challenges) }} Challenges)</div>
                <div class="panel-heading">  
                    {{ link_to_route('challenge.create','Add new challenge', ['project_id' =>$project->project_id], ['class' => 'btn btn-success'] ) }} 
                </div>
            </div>
            @foreach ($challenges as $challenge)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-10">
                            <h4> {{ link_to_route('challenge.show', $challenge->title , [$challenge->challenge_id]) }}   </h4>
                        </div>
                        <div class="col-xs-2">
                            {{ $challenge->participation_number }} participation

                        </div>
                    </div>

                </div>
                <div class="panel-body">
                    <div class="col-md-5 col-md-offset-7">

                        {!! Form::open(array('route'=>['challenge.destroy', $challenge->challenge_id],'method' => 'DELETE')) !!}
                        {{ link_to_route('challenge.edit', 'Edit' , [$challenge->challenge_id], ['class' => 'btn btn-primary']) }}
                        {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                        {{ link_to_route('criterion.index', ' Show Grid' , ['challenge_id' => $challenge->challenge_id], ['class' => 'btn btn-warning glyphicon glyphicon-th']) }}
                        {!! Form::close() !!}

                    </div>
                    <div class="col-xs-12 col-md-12" >
                        <div >

                            {{   $challenge->description   }} 
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@include ('projects.sponsorize-modal')
@endsection
