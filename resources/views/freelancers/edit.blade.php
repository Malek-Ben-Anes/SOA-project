@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
           
                @include('freelancers.image')
            <div class="col-md-8">
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


            @include('skills.skillsCrud')


                     



        </div>
    </div>
@endsection
