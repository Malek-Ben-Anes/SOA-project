@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if(Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">Criterion</div>

            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>Title</th>
                        <th>Mark</th>
                    </tr>


                    @foreach($criterions as $criterion)
                    <tr>
                        <td> {{ $criterion->title }}</td>
                        <td> {{ $criterion->pivot->mark }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
