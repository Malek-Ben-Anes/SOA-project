<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading"><img class="avatar border-white" src="http://localhost/flanci-preparation/public/uploads/enterprise/images/{{ $enterprise->logo==null ? "orange.png" : $enterprise->logo}}" alt="enterprise-logo" width="100" /></div>

        <div class="panel-body">
            {!! Form::model($enterprise,['route' => ['enterprise.update', $enterprise->enterprise_id], 'method' => 'PUT' ])  !!}
            <div class="form-group">
                {!! Form::label('logo', 'Enter image') !!}
                {!! Form::file('logo', null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                {!! Form::button('change Image', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
            <hr /> 
            <div>
                <a href="http://localhost/flanci-preparation/public/uploads/enterprise/enterprise_documents/{{ $enterprise->enterprise_document }}"><img src="http://localhost/flanci-preparation/public/uploads/enterprise/enterprise_documents/document.png" style="width:88px;height:88px;"> </a>
            </div>

        </div>
    </div>
</div>