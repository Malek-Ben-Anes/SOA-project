<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">


            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">Give marks</button>

        </div>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Marks Grid</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>n°</th>
                            <th>Criterion</th>
                            <th>Mark (/20)</th>
                        </tr>
                        @php $i =0 @endphp
                        {{-- {{ $participation->pivot->freelancer_participation_id }} --}}
                        {!! Form::model($criterions,['route' => ['participation.update', $participation->pivot->freelancer_participation_id ], 'method' => 'PUT' ])  !!}
                        {{ Form::hidden('challenge_id', $challenge->challenge_id ) }}
                        {{ Form::hidden('freelancer_id', $participation->freelancer_id ) }}
                        @foreach($criterions as $criterion)
                        <tr>
                            <td> {{ ++$i}} 
                            </td>
                            <td> {{ $criterion->title }}
                            </td>
                            {{-- {{ dd($criterion) }} --}}
                            <td><input type="number" name="{{ $criterion->criterion_id }}" min="0" max="20" step="0.01" value="{{ isset($criterion->pivot->mark)? $criterion->pivot->mark : 0 }}">
                            </td>
                        </tr>
                        @endforeach
{{-- {{ $criterion->pivot->mark  }} --}}
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        {!! Form::button('Send', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>

