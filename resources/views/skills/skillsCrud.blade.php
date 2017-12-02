 <div class="col-md-8 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Skills</div>

                    <div class="panel-body">

                           <div class="form-group">
                                   {!! Form::Label('skill', 'your skills :') !!}
                        @foreach ($freelancer_skills as $skill)
                    {{  Form::button($skill->title,['onClick'=>'updateskill('.
                         $skill->skill_id  .')', 'id' => 'skill-' . $skill->skill_id, 'class' => 'btn btn-success'])  }}
                        @endforeach
                        <br>
                            </div>

                        <div class="form-group">
                            {!! Form::Label('skill', 'choose a new skill :') !!}
                        <select name="skill" onclick="addskill(this.value)" class="btn btn-default" >
                            @foreach ($all_skills as $skill)
                                 <option value="{{  $skill->skill_id  }}">{{  $skill->title  }}</option>
                             @endforeach
                        </select>

                        </div>


                        
                    </div>
                </div>
            </div>


            