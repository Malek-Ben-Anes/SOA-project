@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Balance</h4></div>
                <div class="panel-body">
                    you Having actually: <h4>{{ $balance }} Travel Coins</h4>
                    <div class="col-md-offset-8 col-md-4 ">
                        <h4>{{ link_to_route('billing.transactions', 'View Last transactions') }}</h4>
                    </div>
                </div>
            </div>
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">pack</div>
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>Travel Coins</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        @foreach($packs as $pack)
                        <tr>
                            <td>{{ $pack->coins }} <sup>TC</sup></td>
                            <td>{{ $pack->price }}</td>
                            <td> {{ link_to_route('pack.show', 'Buy', [$pack->pack_id], ['class' => 'btn btn-warning']) }} </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
