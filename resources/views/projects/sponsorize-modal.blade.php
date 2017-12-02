<!-- Modal -->
<div class="modal fade" id="sponsorizeModal" tabindex="-1" role="dialog" aria-labelledby="sponsorizeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="sponsorizeModalLabel">sponsorize modal</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('project.sponsored') }}">
                    {{ csrf_field() }}
                    {{ Form::hidden('project_id',  $project->project_id ) }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-8 col-md-offset-2">
                            <label for="sponsorise" >You want to boost this project</label><br>
                            @if ($project->sponsored == 1)
                              <input type="checkbox" id="sponsorise" name="sponsorise" value="1" checked disabled>Sponsorize the project  ( <b>Already sponsored</b> )<br>
                            @else
                                <input type="checkbox" id="sponsorise" name="sponsorise" value="1" checked >Sponsorize the project  ( 100<sup>FC</sup>)<br>
                            @endif
                            <input type="checkbox" id="notify" name="notify" value="1">Notify all corresponded Freelancers ( 50<sup>FC</sup>) <br>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-success">
                                Validate
                            </button>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>                   
            </div>
        </div>
    </div>
</div>
