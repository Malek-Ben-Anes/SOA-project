@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">HOT DEALS</div>
                <div class="panel-body">Whether you're looking for awesome hotel deals at your favorite travel sites, unsold rooms, or a wallet-friendly rate that fits your budget, Fast Travel offers more than 173,000 hotels throughout North America, Europe, Latin America and Asia. And if you're looking for cheap hotels, or one that's located in your desired destination, Fast Travel has just what you're looking for as your go-to source among travel sites.</div>
            </div>
            <div class="panel panel-default">
                @if (Auth::guest())
                <div class="panel-heading">COINS STORE</div>
                <div class="panel-body">get 20 Free Coins<br>
                <button class="register btn btn-link">Go to store</button>
                </div>
                @else
                <div class="panel-heading">view Balance </div>
                <div class="panel-body">
                <h5>{{ link_to_route('pack.index', 'Go to store', null) }}</h5><br />
                <h5>{{ link_to_route('billing.transactions', 'View last your last transactions', null) }}</h5>
                </div>
                @endif
            </div>
        </div>
        <br>
        <div class="col-md-8">
            
                    {{ Form::open(array('route' => 'project.search', 'method' => 'get')) }}
                    <div class="input-group">
                        <input list="destination" type="text" class="form-control" name="skill" placeholder="Search for destination..." id="suggestion" onkeyup="suggestions(this.value)">
                            <datalist id="destination">
                                <option value="Paris">
                                <option value="Spain">
                                <option value="New york">
                          </datalist>
                        <br/>
                        <span class="input-group-btn">
                            <input class="btn btn-secondary" type="submit" value="Go!">
                        </span>
                    </div>
                
                    {{ Form::close() }}
                <br><br>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ $project_number }} offers</div>
            </div>
            @if ( !Auth::guest() && !(Auth::user()->type    == "freelancer") )
            <div class="panel panel-default">
                <div class="panel-heading">create new project</div>
                <div class="panel-heading"> {{ link_to_route('project.create','Add new project', null, ['class' => 'btn btn-success']) }}</div>
            </div>
            @endif

            @if ($project_number != 0)
            @foreach ($projects as $project)
            @include('projects.project-template')
            @endforeach
            {{ $projects->links() }}
            @else
            <div class="alert alert-warning"><h5>No projects that requires this skill</h5></div>
            @endif

        </div>
    </div>
</div>
@endsection
