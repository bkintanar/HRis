{!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('user[id]') !!}
    {!! Form::hidden('id') !!}

    <!-- End - Employment Commencement -->
    <div class="form-group">
            <label for="job_title_id" class="col-md-2 control-label">Job Title</label>
            <div class="col-sm-4">
                {!! Form::select('job_title_id', HRis\JobTitle::lists('name', 'id'), $employee->job_title_id, ['class' => 'form-control chosen-select', $disabled]) !!}
            </div>

            <label for="employment_status_id" class="col-md-2 control-label">Employment Status</label>
            <div class="col-sm-4">
                {!! Form::select('employment_status_id', HRis\EmploymentStatus::lists('name', 'id'), $employee->employment_status_id, ['class' => 'form-control chosen-select', $disabled]) !!}
            </div>
    </div>
    <!-- End - Job Details -->

    <div class="form-group">

            <label for="department_id" class="col-md-2 control-label">Department</label>
            <div class="col-sm-4">
                {!! Form::select('department_id', HRis\Department::lists('name', 'id'), $employee->department_id, ['class' => 'form-control chosen-select', $disabled]) !!}
            </div>

            <label for="effective_date" class="col-md-2 control-label">Effective Date</label>
            <div class="col-md-4" id="datepicker">
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('effective_date', null, ['class' => 'form-control', 'data-mask' => '9999-99-99', $disabled]) !!}
                    </div>
            </div>

    </div>

    <div class="form-group">

            <label for="" class="col-md-2 control-label">Location</label>
            <div class="col-sm-4">
                <select class="form-control chosen-select" id="" name="">
                    <option value="0">
                        --- Select ---
                    </option>
                    <option value="1">Cebu</option>
                    <option value="2">Manila</option>
                </select>
            </div>

            <label for="" class="col-md-2 control-label">Work Shift</label>
            <div class="col-sm-4">
                        {!! Form::select('work_shift_id', HRis\WorkShift::lists('name', 'id'), $employee->work_shift_id, ['class' => 'form-control chosen-select', $disabled]) !!}

            </div>

    </div>

    <div class="form-group">

            <label for="" class="col-md-2 control-label">Comments</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="3"></textarea>
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
            {!! Html::link(str_replace('/edit', '', \Request::path()), 'Cancel', ['class' => 'btn btn-white']) !!}
            {!! Form::submit('Save changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    @else
        @if($loggedUser->hasAccess(\Request::segment(1).'.job.update'))
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                {!! Html::link(\Request::path() . '/edit', 'Modify', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        @endif
    @endif

{!! Form::close() !!}