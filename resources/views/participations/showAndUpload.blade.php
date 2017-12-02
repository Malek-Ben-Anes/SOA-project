@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"> {{ $challenge->title }}</div>

                    <div class="panel-body">

                      <h1>Participation</h1>
                        <div class="row">
                            @if (Auth::guest())
                        {{  Form::button('participate',['onClick'=>'getInterested('.
                         $challenge->challenge_id  .')', 'id' => 'interest-' . $challenge->challenge_id, 'class' => 'btn btn-default'])}} 
                         @else
                         {{  Form::button('participate',['onClick'=>'getInterested('.
                         $challenge->challenge_id  .')', 'id' => 'interest-' . $challenge->challenge_id, 'class' => $challenge->freelancer_interest == 1 ? 'btn btn-success':'btn btn-default'])  }}
                        @endif
                    </div>


                    {{ $challenge->description }}
                   </div>
                </div>
                @if ( count( $errors ) > 0 )
                    <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @include('challenges.blog')
    </div>
@endsection

