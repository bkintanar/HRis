{!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', Request::path()), 'class' => 'form-horizontal']) !!}
    {!! Form::hidden('employee_id', $employee->id) !!}

    <div class="form-group">

            <label for="" class="col-md-2 control-label">Work Shift</label>
            <div class="col-sm-4">
                {!! Form::select('work_shift_id', HRis\Eloquent\WorkShift::listsWithPlaceholder('name', 'id'), $employee->employeeWorkShift()->first() ? $employee->employeeWorkShift()->first()->work_shift_id : 0, ['class' => 'form-control chosen-select form-fields', $disabled]) !!}
            </div>

            <label for="effective_date" class="col-md-2 control-label">Effective Date</label>
            <div class="col-md-4" id="datepicker">
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('effective_date', isset($employee->jobHistory()->effective_date) ? $employee->jobHistory()->effective_date->toDateString() : null, ['class' => 'form-control form-fields', 'data-mask' => '9999-99-99', $disabled]) !!}
                    </div>
            </div>

    </div>


    <div class="hr-line-dashed"></div>

    @if ($disabled == '')
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            {!! Html::link(str_replace('/edit', '', Request::path()), 'Cancel', ['class' => 'btn btn-white btn-xs']) !!}
            {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs', 'id' => 'save-button']) !!}
        </div>
    </div>
    @else
        @if($logged_user->hasAccess(Request::segment(1).'.work-shift.update'))
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                {!! Html::link(Request::path() . '/edit', 'Modify', ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
        </div>
        @endif
    @endif

{!! Form::close() !!}
