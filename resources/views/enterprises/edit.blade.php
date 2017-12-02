@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Update enterprise Profile</div>
                <div class="panel-body">
                    <div><img class="avatar border-white" src="http://localhost/flanci-preparation/public/uploads/enterprise/images/{{ $enterprise->logo==null ? "orange.png" : $enterprise->logo}}" alt="enterprise-logo" width="100" />
                    </div>
                    {!! Form::model($enterprise,['route' => ['enterprise.update', $enterprise->enterprise_id], 'method' => 'PUT', 'files' => true  ])  !!}

                    <div class="form-group">
                        {!! Form::label('logo', 'Enter image') !!}
                        {!! Form::file('logo', null, ['class' => 'form-control']) !!}
                    </div>
                    <div>
                        <a href="http://localhost/flanci-preparation/public/uploads/enterprise/enterprise_documents/{{ $enterprise->enterprise_document }}"><img src="http://localhost/flanci-preparation/public/uploads/enterprise/enterprise_documents/document.png" style="width:88px;height:88px;"> </a>
                    </div>
                    <div class="form-group">
                        {!! Form::label('enterprise_name', 'Enterprise Name') !!}
                        {!! Form::text('enterprise_name', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('phone', 'Enter Phone') !!}
                        {!! Form::number('phone', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('address', 'Address') !!}
                        {!! Form::text('address', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Enter description') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::button('Update Profile', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
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
