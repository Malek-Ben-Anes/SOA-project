<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">

            <div class="panel-body">
                {{-- {{ dd($comments) }} --}}
                @foreach ($comments as $comment)
                <!-- Single Comment -->
                <div class="media mb-4">
                    <div class="col-md-2">
                        <img class="thumbnail" src="{{ URL::asset($comment->image ) }}" alt="commenter-image" style="width:68px;height:68px;">
                    </div>
                    <div class="col-md-10">
                        <div class="media-body">
                            <h5 class="mt-0">
                                @if ($comment->type == "freelancer")
                                {{ link_to_route('freelancer.show', $comment->username, [$comment->user_id]) }}
                                @else
                                {{ link_to_route('enterprise.show', $comment->username, [$comment->user_id]) }}
                                @endif
                            </h5> 
                        </div>
                        {{ $comment->pivot->created_at}}
                    </div>
                    <div class="col-md-12">
                        {{ $comment->pivot->content }}
                    </div>
                </div>
                @endforeach
                <br>
                <!-- Comments Form -->
                <div class="card my-4">
                    <div class="card-body">
                        @if (Auth::guest())
                        <div class="form-group">
                            {!! Form::label('content', 'Leave a comment') !!}
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <button class="register btn btn-primary">Comment</button>
                        @else

                        {!! Form::open(['route' => 'comment.store'])  !!}
                        {{ Form::hidden('project_id',  $project->project_id) }}
                        <div class="form-group">
                            {!! Form::label('content', 'Leave a comment') !!}
                            {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                        <button type="submit" class="btn btn-primary">Comment</button>
                        {!! Form::close() !!}
                    </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

</div>
