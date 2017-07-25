@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create task</div>

                    <div class="panel-body">

                        our form
                        {!! Form::open(['route' => 'task.store'])  !!}
                            <div class="form-group">
                                {!! Form::label('title', 'Enter Title') !!}
                                {!! Form::text('title', null, ['class' => 'form-control']) !!}
                            </div>
                        <div class="form-group">
                            {!! Form::label('body', 'Enter body') !!}
                            {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::button('create', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
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
