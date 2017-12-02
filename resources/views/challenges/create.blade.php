@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create challenge</div>

                    <div class="panel-body">
                        our form
                        {!! Form::open(['route' => 'challenge.store'])  !!}
                         {{ Form::hidden('enterprise_id',  Auth::user()->user_id ) }}
                         {{ Form::hidden('project_id',  app('request')->input('project')  ) }}
                            <div class="form-group">
                                {!! Form::label('title', 'Enter Title') !!}
                                {!! Form::text('title', null, ['class' => 'form-control']) !!}
                            </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Enter description') !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('challenge_document', 'Enter challenge document') !!}
                            {!! Form::text('challenge_document', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('winner_number', 'Enter winner number') !!}
                            {!! Form::text('winner_number', null, ['class' => 'form-control']) !!}
                        </div>
                         <div class="form-group">
                            {!! Form::label('start_date', 'Enter starting date') !!}
                             {{ Form::date('start_date', \Carbon\Carbon::now()) }}
                        </div>
                         <div class="form-group">
                            {!! Form::label('end_date', 'Enter ending date') !!}
                             {{ Form::date('end_date', \Carbon\Carbon::now()) }}
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
