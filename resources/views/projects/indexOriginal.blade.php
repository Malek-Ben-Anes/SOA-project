@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Task</div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>


                        @foreach($projects as $project)
                        <tr>
                            <td> {{ link_to_route('project.show', $project->title, [$project->project_id]) }}
                            </td>
                            <td>

                                {!! Form::open(array('route'=>['project.destroy', $project->project_id],'method' => 'DELETE')) !!}
                                {{ link_to_route('project.edit','Edit', [$project->project_id], ['class' => 'btn btn-primary']) }}
                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            {{ link_to_route('project.create','Add new project', null, ['class' => 'btn btn-success']) }}
        </div>
    </div>
</div>
@endsection
