@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h4>( {{ $all_transactions }}) Transactions</h4> {{ link_to_route('pack.index', 'Back to store', ['class' => 'btn btn-default']) }}
            @foreach ($transactions as $transaction)
            @if ($transaction->type == "transaction")
            <div class="panel panel-default">
                <div class="panel-heading">+{{ $transaction->coins }} <sup>TC</sup></div>

                <div class="panel-body">
                    {{ $transaction->created_at }}
                </div>
            </div>
            @else
            <div class="panel panel-default">
                <div class="panel-heading">- {{ $transaction->coins }} <sup>TC</sup></div>
                <div class="panel-body">
                    {{ $transaction->created_at }}<br>
                    {{ $transaction->description }} {{ $transaction->enterprise_name }}
                </div>
            </div>
            @endif

            @endforeach
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
