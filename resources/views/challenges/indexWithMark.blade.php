@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
        {{-- {{  dd($criterions)  }} --}}
            <div class="col-md-8 col-md-offset-2">
                @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Challenges Participation</div>

                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th>title</th>
                                <th>Winner number</th>
                                <th>Description</th>
                                <th>Mark Average</th>
                                <th>View participation</th>
                            </tr>
                          

                       @foreach($challenges as $challenge )
                           <tr>
                            <td> {{ link_to_route('challenge.show', $challenge->challenge_id, [$challenge->challenge_id]) }}
                            </td>
                            <td>{{ $challenge->title }}</td>
                            <td>{{ $challenge->winner_number }}</td>
                            <td>{{ $challenge->description }}</td>
                            <td>{{ link_to_route('marks.show', $challenge->markAverage, [$challenge->challenge_id]) }}</td>
                            
                            {{-- {{ $criterions->title }} --}}
                            </td>
                            <td>

                                 {{ link_to_route('showParticipation', 'view Participation',
                            ['challenge_id' => $challenge->challenge_id, 'participation_id'=>$challenge->pivot->freelancer_participation_id]
                            , ['class' => 'btn btn-warning'])  }}


                            </td>
                           </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
