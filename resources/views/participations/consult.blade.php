@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"> Freelancer participation </div>

                    <div class="panel-body">
                    <div>
                      freelancer_pseudonym:  
                      {{ link_to_route('freelancer.show', $participation->pseudonym, [$participation->freelancer_id])  }}
                    </div>
                    {{-- {{ dd($criterions) }} --}}
                    <div>
                    <div>message : {{ $participation->pivot->message }}</div>
                    <div>
                     <a href="{{ $participation->pivot->document }}"><img src="http://localhost/flanci-preparation/public/uploads/projects/www.downloadzen.com.png" style="width:88px;height:88px;"> </a>
                     </div>
                    </div>

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
        @include('criterions.grid-template')
    </div>
@endsection
