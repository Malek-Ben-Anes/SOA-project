@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Freelancers Profiles</div>

                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Description</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </tr>


                       @foreach($freelancers as $freelancer)
                           <tr>
                            <td> {{ link_to_route('freelancer.show', $freelancer->freelancer_id, [$freelancer->freelancer_id]) }}
                            </td>
                            <td>{{ $freelancer->first_name }}</td>
                            <td>{{ $freelancer->last_name }}</td>
                            <td>{{ $freelancer->short_description }}</td>
                            <td>{{ $freelancer->phone }}</td>
                            <td>{{ $freelancer->short_description }}</td>
                           </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
