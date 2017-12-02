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
                    </div>
                    <p>  {{ $project->description }}</p>
                    here we put project details
                </div>
            </div>
            
            <h2> list of challenges ({{ count($challenges) }} Challenges)</h2>
            <div> {{ link_to_route('challenge.create','Add new challenge', 'project=' . $project->project_id, ['class' => 'btn btn-success']) }}</div>
            <br>
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
