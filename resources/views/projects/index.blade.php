@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif

                       @foreach($projects as $project)
                            @include('projects.project-template')    
                        @endforeach
                       
                    </div>
                </div>
                
            </div>
        
@endsection
