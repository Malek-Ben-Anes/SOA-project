@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            
            <div class="panel panel-default">

                <div class="panel-heading"> Freelancer Account </div>

                <div class="panel-body">
                    <img class="avatar border-white" src="http://localhost/flanci-preparation/public/uploads/freelancer/images/{{ $freelancer->image }}" alt="freelancer-image" width="100" />
                    {{ $freelancer->description }}
                    
                    <table>
            <tr>
            @for ($i = 1; $i < 7; $i++)
                <td>
                @if (in_array($i, $freelancer->badge))
                    <img class="avatar border-white" src="http://localhost/flanci-preparation/public/uploads/freelancer/badges/badge-{{ $i }}.png" alt="freelancer-image" width="28"  height="28" />
                @else
                    <img class="avatar border-white" src="http://localhost/flanci-preparation/public/uploads/freelancer/badges/badge-locked-{{ $i }}.png" alt="freelancer-image" width="28"  height="28" />
                @endif
                </td>
            @endfor
                </tr>
                <tr>
                <td>verified,   &nbsp;  </td>
                <td>selected,   &nbsp;</td>
                <td>unlocked,   &nbsp;&nbsp;</td>
                <td>fast,   &nbsp;&nbsp;</td>
                <td>trending,   &nbsp;</td>
                <td>& famous &nbsp;</td>
                </tr>
            </table>
                    
                    <div class="form-group">
                        {!! Form::label('first_name', 'First Name') !!}
                        {{ $freelancer->first_name }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('last_name', 'Last Name') !!}
                        {{ $freelancer->last_name }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'description') !!}
                        {{ $freelancer->description }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone', 'Phone') !!}
                        {{ $freelancer->phone }}
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', 'email') !!}
                        {{ $freelancer->email }}
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
                <div class="panel-heading">Participation Challenges List</div>

                <div class="panel-body">

                    @foreach ($challenges as $challenge)
                    <h5>{{ $challenge->title }}</h5> <br>
                    project description: {{ $challenge->description }} <br> <hr>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
