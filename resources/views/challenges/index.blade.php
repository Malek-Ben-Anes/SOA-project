@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Challenge</div>

                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>


                       @foreach($challenges as $challenge)
                           <tr>
                            <td> {{ link_to_route('challenge.show', $challenge->title, [$challenge->challenge_id]) }}
                            </td>
                            <td>

                                {!! Form::open(array('route'=>['challenge.destroy', $challenge->challenge_id],'method' => 'DELETE')) !!}
                                {{ link_to_route('challenge.edit','Edit', [$challenge->challenge_id], ['class' => 'btn btn-primary']) }}
                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                           </tr>
                            @endforeach
                            <tr>
                                <td>total</td>
                                <td>{{ count($challenges) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                {{ link_to_route('challenge.create','Add new challenge', null, ['class' => 'btn btn-success']) }}
            </div>
        </div>
    </div>
@endsection
