@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-4">
             <div class="panel panel-default">
                    <div class="panel-heading"> 
                    <img src="{{ URL::asset('/uploads/enterprise/background.jpg') }}" alt="..." width="150px" /></div>

                    <div class="panel-body">

                        <div class="card">
                            <div class="content">

                                <div class="card card-user">
                            <div class="image">
                               
                            </div>
                            <div class="content">
                                <div class="author">
                                  <img class="avatar border-white" src="{{ URL::asset('/uploads/enterprise/images/logo.png') }}" alt="..." width="150px" />
                                  <h4 class="title">{{ $enterprise->first_name }} {{ $enterprise->last_name }}<br />
                                     <a href="#"><small>&#64;{{ $enterprise->first_name }}{{ $enterprise->last_name }} </small></a>
                                  </h4>
                                </div>
                                <p class="description text-center">
                                    "{!! $enterprise->short_description !!}"
                                </p>
                            </div>
                            <hr>
                        </div>


                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                     <div class="header">
                                <h4 class="title">show Enterprise profile for visitors</h4>
                            </div></div>

                    <div class="panel-body">




                       
                        <div class="card">
                            <div class="content">
                                <form>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" name="username" class="form-control border-input" placeholder="Username" value="{{ $enterprise->username }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control border-input" placeholder="{{ $enterprise->email }}" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="number" name="phone" class="form-control border-input" placeholder="Company" value="{{ $enterprise->phone }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" class="form-control border-input" placeholder="Home Address" value="{{ $enterprise->address }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" name="city" class="form-control border-input" placeholder="City" value="{{ $enterprise->city }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" name="country" class="form-control border-input" placeholder="Country" value="{{ $enterprise->country }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="number" class="form-control border-input" placeholder="{{ $enterprise->postal_code }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea rows="5" class="form-control border-input" placeholder="Here can be your description" value="Mike">{{ $enterprise->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
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
    </div>
@endsection
