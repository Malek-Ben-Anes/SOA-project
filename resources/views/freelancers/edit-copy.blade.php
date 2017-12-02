@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update freelancer Profile</div>

                <div class="panel-body">
                    {!! Form::model($freelancer,['route' => ['freelancer.update', $freelancer->freelancer_id], 'method' => 'PUT' ])  !!}
                    <div class="form-group">
                        {!! Form::label('first_name', 'First Name') !!}
                        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('last_name', 'Last Name') !!}
                        {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('pseudonym', 'pseudonym') !!}
                        {!! Form::text('pseudonym', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('short_description', 'short description') !!}
                        {!! Form::text('short_description', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone', 'Enter Phone') !!}
                        {!! Form::number('phone', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('image', 'Enter image') !!}
                        {!! Form::file('image', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Enter description') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::button('Update Profile', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                    </div>
                    <div>
                        {!! Form::label('Skills', 'Skills') !!}
                        @foreach ($skills as $skill)
                        <button class="btn btn-warning" type="button"> {{ $skill->title }} </button>
                        @endforeach
                        <br>
                        {!! Form::select('skill', $array_all_skills , $array_all_skills['1'] ); !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
            @if ( count( $errors ) > 0 )
            <ul class="aler alert-danger">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection
