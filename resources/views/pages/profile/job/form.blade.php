{!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('id') !!}
    {!! Form::hidden('employee_id', $employee->id) !!}

    <!-- End - Employment Commencement -->
    <div class="form-group">
            <label for="job_title_id" class="col-md-2 control-label">Job Title</label>
            <div class="col-sm-4">
                {!! Form::select('job_title_id', HRis\Eloquent\JobTitle::listsWithPlaceholder('name', 'id'), isset($employee->jobHistory()->job_title_id) ? $employee->jobHistory()->job_title_id : 0, ['class' => 'form-control chosen-select form-fields', $disabled]) !!}
            </div>

            <label for="employment_status_id" class="col-md-2 control-label">Employment Status</label>
            <div class="col-sm-4">
                {!! Form::select('employment_status_id', HRis\Eloquent\EmploymentStatus::listsWithPlaceholder('name', 'id'), isset($employee->jobHistory()->employment_status_id) ? $employee->jobHistory()->employment_status_id : 0, ['class' => 'form-control chosen-select form-fields', $disabled]) !!}
            </div>
    </div>
    <!-- End - Job Details -->

    <div class="form-group">

            <label for="department_id" class="col-md-2 control-label">Department</label>
            <div class="col-sm-4">
                {!! Form::select('department_id', HRis\Eloquent\Department::listsWithPlaceholder('name', 'id'), isset($employee->jobHistory()->department_id) ? $employee->jobHistory()->department_id : 0, ['class' => 'form-control chosen-select form-fields', $disabled]) !!}
            </div>

            <label for="effective_date" class="col-md-2 control-label">Effective Date</label>
            <div class="col-md-4" id="datepicker">
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('effective_date', isset($employee->jobHistory()->effective_date) ? $employee->jobHistory()->effective_date : null, ['class' => 'form-control form-fields', 'data-mask' => '9999-99-99', $disabled]) !!}
                    </div>
            </div>

    </div>

    <div class="form-group">

            <label for="" class="col-md-2 control-label">Location</label>
            <div class="col-sm-4">
                {!! Form::select('location_id', HRis\Eloquent\Location::listsWithPlaceholder('name', 'id'), isset($employee->jobHistory()->location_id) ? $employee->jobHistory()->location_id : 0, ['class' => 'form-control chosen-select form-fields', $disabled]) !!}
            </div>

            <label for="" class="col-md-2 control-label">Work Shift</label>
            <div class="col-sm-4">
                {!! Form::select('work_shift_id', HRis\Eloquent\WorkShift::listsWithPlaceholder('name', 'id'), isset($employee->employeeWorkShift->work_shift_id) ? $employee->employeeWorkShift->work_shift_id : 0, ['class' => 'form-control chosen-select form-fields', $disabled]) !!}
            </div>

    </div>

    <div class="form-group">

            <label for="" class="col-md-2 control-label">Comments</label>
            <div class="col-sm-10">
                {!! Form::textarea('comments', null, ['class' => 'form-control form-fields', 'rows' => '3', $disabled, 'style' => 'resize:vertical;']) !!}
            </div>


    </div>

    <div class="hr-line-dashed"></div>
    <!-- End - Contact -->

    <h4>Employment Commencement</h4><br />
        <div class="form-group">
                <label for="joined_date" class="col-md-2 control-label">Joined Date</label>
                <div class="col-md-4" id="datepicker">
                        <div class="input-group date" id="data_1">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('joined_date', null, ['class' => 'form-control', 'data-mask' => '9999-99-99', $disabled]) !!}
                        </div>
                </div>

                <label for="probation_end_date" class="col-md-2 control-label">Probation End Date</label>
                <div class="col-md-4" id="datepicker">
                        <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('probation_end_date', null, ['class' => 'form-control', 'data-mask' => '9999-99-99', $disabled]) !!}
                        </div>
                </div>
        </div>

        <div class="form-group">
                <label for="permanency_date" class="col-md-2 control-label">Date of Permanency</label>
                <div class="col-md-4" id="datepicker">
                        <div class="input-group date" id="data_1">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('permanency_date', null, ['class' => 'form-control', 'data-mask' => '9999-99-99', $disabled]) !!}
                        </div>
                </div>
        </div>
    <div class="hr-line-dashed"></div>

    @if ($disabled == '')
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            {!! Html::link(str_replace('/edit', '', \Request::path()), 'Cancel', ['class' => 'btn btn-white btn-xs']) !!}
            {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs', 'id' => 'save-button']) !!}
        </div>
    </div>
    @else
        @if($loggedUser->hasAccess(\Request::segment(1).'.job.update'))
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                {!! Html::link(\Request::path() . '/edit', 'Modify', ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
        </div>
        @endif
    @endif

{!! Form::close() !!}