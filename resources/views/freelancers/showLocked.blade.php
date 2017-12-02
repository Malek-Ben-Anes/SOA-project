@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        @if(Session::has('message'))
            <div class="alert alert-danger">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading"> {{ $freelancer->pseudonym }}</div>

                <div class="panel-body">
                    <img class="avatar border-white" src="http://localhost/flanci-preparation/public/uploads/freelancer/images/{{ $freelancer->image }}" alt="freelancer-image" width="100" />
                    {{ $freelancer->description }}
                    <div class="row">
                        <div class="col-md-8">
                            {!! Form::label('short_description', 'Short description') !!}
                            {{ $freelancer->short_description }}

                        </div>

                        <div class="col-md-2">
                        @if (Auth::guest())

                            <button class="register btn btn-primary">Unlock freelancer (50 <sup>FC</sup>)</button>
                            @else
                            {{  link_to_route('freelancer.unlock',html_entity_decode('Unlock freelancer'),[$freelancer->freelancer_id] , ['class' => 'btn btn-primary']) }} (50 <sup>FC</sup>)
                            @endif

                        </div>
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

        </div>
    </div>
</div>
@endsection
