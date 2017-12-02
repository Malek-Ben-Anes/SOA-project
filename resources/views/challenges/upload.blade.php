@extends('layouts.app')

@section('content')
<div class="container">
{{-- {{ dd(Session::all()) }} --}}
    <div class="row">

                @include('participations.consult-template')
               
               
                  


        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Participation Form: // you have to show last participation</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('challenge.upload') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="message" class="col-md-4 control-label">Message</label>

                            <div class="col-md-6">
                                <input id="message" type="text" class="form-control" name="message" value="{{ old('message') }}" required autofocus>
                                    {{ Form::hidden('attach_document')  }}
                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif

                                @if(Session::has('message'))
                                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="attach_document" class="col-md-4 control-label">Attach document: (put a zip file please)</label>
                            <div class="col-md-6">
                               {{ Form::file('attach_document')  }}
                                <span class="required" id='spnFileError'></span>
                             @if ($errors->has('attach_document'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('attach_document') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Participation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
