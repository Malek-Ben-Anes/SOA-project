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
                <div> {{ link_to_route('challenge.create','Add new challenge', 'project=' . $project->project_id, ['class' => 'btn btn-success']) }}</div>
            </div>
        </div>
    </div>
@endsection
