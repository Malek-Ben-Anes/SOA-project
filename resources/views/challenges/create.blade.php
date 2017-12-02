@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create New challenge</div>

                <div class="panel-body">
                    {!! Form::open(['route' => 'challenge.store'])  !!}
                    {{ Form::hidden('enterprise_id',  Auth::user()->user_id ) }}
                    {{ Form::hidden('project_id',  app('request')->input('project_id')  ) }}
                    <div class="form-group">
                        {!! Form::label('title', 'Enter Title') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Enter description') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::button('create', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                        {{ link_to_route('project.edit', 'Back', [app('request')->input('project_id') ], ['class' => 'btn btn-default']) }}
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
