@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Enter message code</div>
                <div class="panel-body">
                    @if(Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('billing.secondWebService') }}">
                        {{ csrf_field() }}
                        {{ Form::hidden('pack_id',  $pack_id ) }}
                        {{ Form::hidden('location',  $location ) }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="phone_number" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="number" class="form-control" name="phone_number" max="99999999" min=0 value="{{ old('phone_number')!=null ? old('phone_number') : $phone_number }}" required>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="code_verif" class="col-md-4 control-label">Verification Code</label>

                            <div class="col-md-6">
                                <input id="code_verif" type="number" class="form-control" name="code_verif" min="0000" max="9999" value="{{ old('code_verif') }}" required>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Request
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
