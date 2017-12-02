    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Participations</div>

                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>freelancer Psuedonym</th>
                                <th>message</th>
                                <th>Work</th>
                            </tr>
                       @foreach($participations as $participation)
                           <tr>
                            <td>{{ link_to_route('freelancer.show', $participation->pseudonym, [$participation->freelancer_id])  }}</td>
                            <td>{{ $participation->message }}</td>
                            <td>{{ link_to_route('showParticipation', 'view Participation',
                            ['challenge_id' => $participation->challenge_id, 'participation_id'=>$participation->freelancer_participation_id]
                            , ['class' => 'btn btn-warning'])  }}</td>
                           </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

