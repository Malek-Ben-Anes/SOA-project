@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if ( count( $errors ) > 0 )
            <ul class="aler alert-danger">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Create New project (50 FC)</div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'project.store'])  !!}
                    {{ Form::hidden('enterprise_id',  Auth::user()->user_id ) }}
                    <div class="form-group">
                        {!! Form::label('title', 'Enter Title') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('budget', 'Enter Project Budget') !!}
                        {!! Form::number('budget', null, array('class' => 'form-control','step'=>'any')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('starting_date', 'Your project will start in') !!}
                        {{ Form::date('starting_date',  Carbon\Carbon::now()->format('Y-m-d')  , ['class' => 'form-control', 'disabled']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('Ending_Date', 'Enter project ending date (duration Max is 15 days) ') !!}
                        {{ Form::date('Ending_Date',  Carbon\Carbon::now()->addDays(1)->format('Y-m-d')  , ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {!! Form::label('Ending_Hour', null) !!}
                        {!! Form::selectRange('hour', 0, 23 , Carbon\Carbon::now()->format('H') , ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-3">
                        {!! Form::label('Ending_Minute', null) !!}
                        {!! Form::selectYear('year',0, 59, Carbon\Carbon::now()->format('i') , ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Enter description') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::button('Create New Project', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
</div>
@endsection
