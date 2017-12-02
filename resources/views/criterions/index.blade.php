@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Criterion</div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>


                        @foreach($criterions as $criterion)
                        <tr>
                            <td> {{ link_to_route('criterion.show', $criterion->title, [$criterion->criterion_id]) }}
                            </td>
                            <td>

                                {!! Form::open(array('route'=>['criterion.destroy', $criterion->criterion_id],'method' => 'DELETE')) !!}
                                {{ link_to_route('criterion.edit','Edit', [$criterion->criterion_id], ['class' => 'btn btn-primary']) }}
                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            {!! Form::open(['route' => 'criterion.store'])  !!}
                    {{ Form::hidden('challenge_id',  app('request')->input('challenge_id')  ) }}
                    <div class="form-group">
                        {!! Form::label('title', 'Add new criterion') !!}
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::button('Add new criterion', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                        {{ link_to_route('project.edit', 'Back', [$challenge->project_id], ['class' => 'btn btn-default']) }}
                    </div>
                    {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
