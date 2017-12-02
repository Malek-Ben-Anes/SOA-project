@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Update criterion</div>

                <div class="panel-body">

                    our form
                    {!! Form::model($criterion,['route' => ['criterion.update', $criterion->criterion_id], 'method' => 'PUT' ])  !!}
                    <div class="form-group">
                        {!! Form::label('title', 'Enter Title') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                        {{ link_to_route('criterion.index', 'Back', ['challenge_id' => $criterion->challenge_id], ['class' => 'btn btn-default']) }}
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
