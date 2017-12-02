@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
           
                @include('enterprises.image')
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Update enterprise Profile</div>

                    <div class="panel-body">
                        {!! Form::model($enterprise,['route' => ['enterprise.update', $enterprise->enterprise_id], 'method' => 'PUT' ])  !!}
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


            {{-- @include('skills.skillsCrud') --}}


                     



        </div>
    </div>
@endsection
