@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Enterprise Profile</div>
                <div class="panel-body">
                    <div><img class="avatar border-white" src="http://localhost/flanci-preparation/public/uploads/enterprise/images/{{ $enterprise->logo }}" alt="enterprise-logo" width="89" height="89" />
                        {{-- {{ dd($enterprise) }} --}}
                    </div>
                    <div class="form-group">
                        {!! Form::label('enterprise_name', 'Enterprise Name: ') !!}
                        {{ $enterprise->enterprise_name }}
                    </div>

                    <div class="form-group">
                        {!! Form::label('created_at', 'Creation Date: ') !!}
                        {{ $enterprise->created_at }}
                    </div>

                    <div class="form-group">
                        {!! Form::label('phone', 'Enter Phone') !!}
                        {{ $enterprise->phone }}
                    </div>

                    <div class="form-group">
                        {!! Form::label('address', 'Address: ') !!}
                        {{ $enterprise->address }}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Enter description: ') !!}
                        {{ $enterprise->description }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
