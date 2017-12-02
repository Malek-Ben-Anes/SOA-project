@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Skill</div>

                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>


                       @foreach($skills as $skill)
                           <tr>
                            <td> {{ link_to_route('skill.show', $skill->skill_id, [$skill->skill_id]) }} </td>
                            <td> {{ $skill->title }} </td>
                            <td>

                                {!! Form::open(array('route'=>['skill.destroy', $skill->skill_id],'method' => 'DELETE')) !!}
                                {{ link_to_route('skill.edit','Edit', [$skill->skill_id], ['class' => 'btn btn-primary']) }}
                                {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                           </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                {{ link_to_route('skill.create','Add new skill', null, ['class' => 'btn btn-success']) }}
            </div>
        </div>
    </div>
@endsection
