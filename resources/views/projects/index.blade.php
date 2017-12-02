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
                <div class="panel-body">this is checkbox</div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Search By skills</div>
                <div class="panel-body">this is checkbox</div>
            </div>
        </div>
        <!-- Search Widget -->
        <div class="col-md-8">
            <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
            <br />
            <div class="panel panel-default">
                <div class="panel-heading">{{ $project_number }} offers</div>
            </div>
            @if ( !Auth::guest() && !(Auth::user()->type    == "freelancer") )
            <div class="panel panel-default">
                <div class="panel-heading">create new project</div>
                <div class="panel-heading"> {{ link_to_route('project.create','Add new project', null, ['class' => 'btn btn-success']) }}
                </div>
            </div>
            @endif
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}
            </div>
            @endif

            @foreach($projects as $project)
            @include('projects.project-template')    
            @endforeach

        </div>
    </div>

</div>

@endsection
