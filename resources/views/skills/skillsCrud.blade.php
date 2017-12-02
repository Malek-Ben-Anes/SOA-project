<div class="col-md-8 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">Skills</div>

        <div class="panel-body">

            <div class="form-group" id="skill-group">
                {!! Form::Label('skill', 'your skills :') !!}
                @foreach ($freelancer_skills as $skill)
                {{  Form::button($skill->title,['onClick'=>'updateskill('.
                $skill->skill_id  .')', 'id' => 'skill-' . $skill->skill_id, 'class' => 'btn btn-success'])  }}
                @endforeach
                <br>
            </div>

            <div class="form-group">
                {!! Form::Label('skill', 'choose a new skill :') !!}
                <select id="select-value" name="skill"  class="btn btn-default" >
                    @foreach ($all_skills as $skill)
                    <option value="{{  $skill->skill_id  }}">{{  $skill->title  }}</option>
                    @endforeach
                </select>
                <button type="submit" onclick="addskill( document.getElementById('select-value').value,  document.getElementById('select-value').options[document.getElementById('select-value').selectedIndex].text)" class="btn btn-default">Submit</button>
            </div>
        </div>
    </div>
</div>
