@extends('layouts.app')

@section('content')
<div class="container">
    {{-- {{ dd(Session::all()) }} --}}
    <div class="row">

        @include('participations.consult-template')





        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Participation Form: // you have to show last participation</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('challenge.upload') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ Form::hidden('challenge_id' , $challenge->challenge_id)  }}
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


                            </div>
                        </div>




                        <div class="form-group{{ $errors->has('paritcipation_url') ? ' has-error' : '' }}">
                            <label for="message" class="col-md-4 control-label">Participation URL</label>
                            <div class="col-md-6">
                                <input id="participation-url" type="text" class="form-control" name="paritcipation_url" value="{{ old('paritcipation_url') }}" required autofocus>
                                {{ Form::hidden('attach_document')  }}
                                @if ($errors->has('paritcipation_url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('paritcipation_url') }}</strong>
                                </span>
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
