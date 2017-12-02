@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                <div class="panel panel-default">

                    <div class="panel-heading"> {{ $freelancer->first_name }} {{ $freelancer->last_name }}</div>

                    <div class="panel-body">
                        <img class="avatar border-white" src="http://localhost/flanci-preparation/public/uploads/freelancer/images/{{ $freelancer->image }}" alt="freelancer-image" width="100" />
                    {{ $freelancer->description }}
                    <div class="form-group">
                                {!! Form::label('first_name', 'First Name') !!}
                               {{ $freelancer->first_name }}
                    </div>
                    <div class="form-group">
                                {!! Form::label('last_name', 'Last Name') !!}
                               {{ $freelancer->last_name }}
                    </div>
                    <div class="form-group">
                                {!! Form::label('short_description', 'Short description') !!}
                               {{ $freelancer->short_description }}
                    </div>
                    <div class="form-group">
                                {!! Form::label('phone', 'Phone') !!}
                               {{ $freelancer->phone }}
                    </div>
                     
                   </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Skills</div>
                    <div class="panel-body">
                    <div>
                        @foreach ($skills as $skill)
                        <button class="btn btn-warning" type="button"> {{ $skill->title }} </button>
                        @endforeach
                    </div>
                
                   </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Recommandation  |  &#x2605;  challenges winned</div>

                    <div class="panel-body">

                    @foreach ($projects as $project)
                        project title: {{ $project->title }} <br>
                        project description: {{ $project->description }} <br> <hr>
                    @endforeach
                   </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Interest Projects List</div>

                    <div class="panel-body">

                    @foreach ($projects as $project)
                        project title: {{ $project->title }} <br>
                        project description: {{ $project->description }} <br> <hr>
                    @endforeach
                   </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Participation Challenfes List</div>

                    <div class="panel-body">

                    @foreach ($challenges as $challenge)
                        project title: {{ $challenge->title }} <br>
                        project description: {{ $challenge->description }} <br> <hr>
                    @endforeach
                   </div>
                </div>

            </div>
        </div>
    </div>
@endsection
