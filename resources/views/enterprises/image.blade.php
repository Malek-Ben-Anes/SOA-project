                 <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><img class="avatar border-white" src="http://localhost/flanci-preparation/public/uploads/enterprise/images/{{ $enterprise->logo==null ? "orange.png" : $enterprise->logo}}" alt="enterprise-logo" width="100" /></div>

                    <div class="panel-body">
                        {!! Form::model($enterprise,['route' => ['freelancer.image'], 'method' => 'PUT', 'files' => true ])  !!}
                        <div class="form-group">
                                {!! Form::label('image', 'Enter image') !!}
                                {!! Form::file('image', null, ['class' => 'form-control']) !!}
                            </div>
                            <hr /> 
                            <div class="form-group">
                                {!! Form::label('document', 'Enter document') !!}
                                {!! Form::file('document', null, ['class' => 'form-control']) !!}
                            </div>


                        <div class="form-group">
                            {!! Form::button('change Image', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                       </div>
                       {!! Form::close() !!}

                    </div>
                </div>
                </div>