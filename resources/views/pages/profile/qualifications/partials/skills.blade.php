<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Skills</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                @if($loggedUser->hasAccess(\Request::segment(1).'.qualifications.skills.create'))
                <div class="">
                    <a id="addSkill" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Skill</th>
                                <th>Years of Experience</th>
                                <th class="fix-width">Action</th>
                            </tr>
                        </thead>

                        <tbody id="skillsBody">
                            @if(count($skills))
                                @foreach($skills as $skill)
                                <tr class="skillsList" id="employee_skill_{{HRis\EmployeeSkill::whereSkillId($skill->id)->whereEmployeeId($employee->id)->pluck('id')}}">
                                    <td>{{ HRis\Skill::whereId($skill->id)->pluck('name') }}</td>
                                    <td>{{ HRis\EmployeeSkill::whereSkillId($skill->id)->whereEmployeeId($employee->id)->pluck('years_of_experience') }}</td>
                                    <td>
                                        @if($loggedUser->hasAccess(\Request::segment(1).'.qualifications.skills.update'))
                                        <button rel="editSkill" id="{{HRis\EmployeeSkill::whereSkillId($skill->id)->whereEmployeeId($employee->id)->pluck('id')}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                        @endif
                                        @if($loggedUser->hasAccess(\Request::segment(1).'.qualifications.skills.delete'))
                                        <button rel="deleteSkill" id="{{HRis\EmployeeSkill::whereSkillId($skill->id)->whereEmployeeId($employee->id)->pluck('id')}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">No skills listed</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- Modal -->

    <div class="modal fade" id="skillModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>

                    <h4 class="modal-title" id="myModalLabel">Skill Details</h4>
                </div>

                <div class="modal-body">
                    <!--Add form-->
                    {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', \Request::path()).'/skills', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('id', $employee->id) !!}
                        {!! Form::hidden('employee_skill_id', '', ['id' => 'employee_skill_id']) !!}
                        {!! Form::hidden('_method', 'POST', ['id' => 'skillForm']) !!}
                        <div class="form-group">
                            {!! Form::label('skill_id', 'Skill', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('skill_id', HRis\Skill::lists('name', 'id'), null, ['class' => 'form-control chosen-select']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('years_of_experience', 'Years Experience', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('years_of_experience', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('skill_comment', 'Comments', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('skill_comment', null, ['class' => 'form-control', 'size' => '30x5']) !!}
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-white btn-xs" data-dismiss="modal" type="button">Close</button>
                            {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
                        </div>
                    {!! Form::close() !!}<!--// form-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
