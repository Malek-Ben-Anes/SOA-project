@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">enterprise Panel for Admin</div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Description</th>
                            <th>Reclamations</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>


                        @foreach($enterprises as $enterprise)
                        <tr>
                            <td> {{ link_to_route('enterprise.show', $enterprise->enterprise_id, [$enterprise->enterprise_id]) }}</td>
                            <td> {{ $enterprise->phone  }}</td>
                            <td> {{ $enterprise->phone  }}</td>
                            <td> {{ $enterprise->phone  }}</td>
                            <td> 0 </td>
                            <td> {{ $enterprise->phone  }}</td>
                            <td>

                                {!! Form::open(array('route'=>['enterprise.destroy', $enterprise->enterprise_id],'method' => 'DELETE')) !!}
                                {{ link_to_route('enterprise.edit','Edit', [$enterprise->enterprise_id], ['class' => 'btn btn-primary']) }}
                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            {{ link_to_route('enterprise.create','Add new enterprise', null, ['class' => 'btn btn-success']) }}
        </div>
    </div>
</div>
@endsection
