@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update project</div>

                    <div class="panel-body">
                        {!! Form::model($project,['route' => ['project.update', $project->project_id], 'method' => 'PUT' ])  !!}
                        {{ Form::hidden('enterprise_id',  Auth::user()->user_id ) }}
                            <div class="form-group">
                                {!! Form::label('title', 'Enter Title') !!}
                                {!! Form::text('title', null, ['class' => 'form-control']) !!}
                            </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Enter description') !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('duration', 'Enter duration') !!}
                            {!! Form::number('duration', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                       </div>
                       {!! Form::close() !!}

                    </div>
                      </div>
                       <div class="panel panel-default">
                    <div class="panel-body">
                         <h2> list of challenges </h2>
                @foreach ($challenges as $challenge)
                <div class="panel panel-default">
                    <div class="panel-body">
                    {{ link_to_route('challenge.edit', 'Edit' , [$challenge->challenge_id], ['class' => 'btn btn-primary']) }}

                    {{ $project->challenge_id }}
                    {{ $project->description }}
                    <br /><br />
                    
                        {{   $challenge->challenge_id   }} {{   $challenge->title   }} 
                        <br /> 
                        
                   </div>
                </div>
                @endforeach
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
