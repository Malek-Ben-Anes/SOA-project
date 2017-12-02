@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading"> challenge title: {{ $challenge->title }}</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-9">
                            @if ( Auth::guest() )
                            {{ link_to_route('challenge.upload','participate', ['challenge_id' => $challenge->challenge_id], ['class' => 'btn btn-primary'] )}}
                            to render a login modal
                            @elseif ( Auth::user()->type    !== "enterprise" )
                            {{ link_to_route('challenge.upload','participate', ['challenge_id' => $challenge->challenge_id], ['class' => 'btn btn-primary'] )}}
                            @endif
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
</div>
@endsection

