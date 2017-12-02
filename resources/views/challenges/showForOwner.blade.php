@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-10">
                            <h4> {{ link_to_route('challenge.show', $challenge->title , [$challenge->challenge_id]) }}   </h4>
                        </div>
                        <div class="col-xs-2">
                            {{ $challenge->participation_number }} participation

                        </div>
                    </div>
                    
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-2 col-md-offset-10">
                            {!! Form::open(array('route'=>['challenge.destroy', $challenge->challenge_id],'method' => 'DELETE')) !!}
                            {{ link_to_route('challenge.edit','Edit', [$challenge->challenge_id], ['class' => 'btn btn-primary']) }}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="col-md-10">
                        {{ $challenge->description }}
                    </div>
                </div>
            </div>
        </div>
        @include('participations.index')
    </div>
</div>
@endsection

