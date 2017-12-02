@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"> challenge title: {{ $challenge->title }}</div>

                    <div class="panel-body">

                        dsfsdfq
                        <div class="row">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-3 col-md-offset-9">
                        {!! Form::open(array('route'=>['challenge.destroy', $challenge->challenge_id],'method' => 'DELETE')) !!}
                                {{ link_to_route('challenge.edit','Edit', [$challenge->challenge_id], ['class' => 'btn btn-primary']) }}
                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                                </div>
                    </div>


                    {{ $challenge->description }}
                   </div>
                </div>
                @if ( count( $errors ) > 0 )
                    <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        @include('participations.index')
    @include('challenges.blog')
    </div>
@endsection

