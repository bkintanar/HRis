{!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal', 'onSubmit' => 'checkEmployeeId()', 'id' => 'personalDetailsForm']) !!}
    {!! Form::hidden('user[id]') !!}
    {!! Form::hidden('id') !!}
    <!-- Start - Full Name -->
    <div class="form-group">
    {!! Form::label('first_name', 'Full Name', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            {!! Form::text('first_name', null, ['class' => 'form-control', 'required', $disabled]) !!}
            <span class="help-block m-b-none">First Name</span>
        </div>
        <div class="col-md-2">
            {!! Form::text('middle_name', null, ['class' => 'form-control', $disabled]) !!}
            <span class="help-block m-b-none">Middle Name</span>
        </div>
        <div class="col-md-4">
            {!! Form::text('last_name', null, ['class' => 'form-control', 'required', 'id' => 'last_name', $disabled]) !!}
            <span class="help-block m-b-none">Last Name</span>
        </div>
    </div>
    <!-- End - Full Name -->
    <div class="hr-line-dashed"></div>
    <!-- Start - Employee Id & Face Id -->
    <div class="form-group">
        {!! Form::label('employee_id', 'Employee Id', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('employee_id', null, ['class' => 'form-control', 'data-mask' => 'GWO-9999', 'required' => 'required', $disabled]) !!}
        </div>
        {!! Form::label('face_id', 'Face Id', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('face_id', null, ['class' => 'form-control', 'data-mask' => '999', $disabled]) !!}
        </div>
    </div>
    <!-- End - Employee Id & Face Id -->
    <div class="hr-line-dashed"></div>
    <!-- Start - Gender & Marital Status -->
    <div class="form-group">
        {!! Form::label('gender', 'Gender', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4">
           <label class="radio-inline i-checks">
                {!! Form::radio('gender', 'M', null, [$disabled]) !!} Male
            </label>
            <label class="radio-inline i-checks">
                {!! Form::radio('gender', 'F', null, [$disabled]) !!} Female
            </label>
        </div>

        {!! Form::label('marital_status_id', 'Marital Status', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::select('marital_status_id', $marital_statuses, $employee->marital_status_id, ['class' => 'form-control chosen-select', $disabled]) !!}
        </div>
    </div>
    <!-- End - Gender & Marital Status -->
    <!-- Start - Nationality & DOB -->
    <div class="form-group">
        {!! Form::label('nationality_id', 'Nationality', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::select('nationality_id', HRis\Eloquent\Nationality::lists('name', 'id'), $employee->nationality_id, ['class' => 'form-control chosen-select', $disabled]) !!}
        </div>
        {!! Form::label('birth_date', 'Date of Birth', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4" id="datepicker_birth_date">
            <div class="input-group date">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('birth_date', null, ['class' => 'form-control', 'data-mask' => '9999-99-99', $disabled]) !!}
            </div>
        </div>
    </div>
    <!-- End - Nationality & DOB -->
    <div class="hr-line-dashed"></div>
    <!-- Start - Social Security & Tax Identification -->
    <div class="form-group">
        {!! Form::label('social_security', 'Social Security', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('social_security', null, ['class' => 'form-control', 'data-mask' => '99-9999999-9', $disabled]) !!}
        </div>
        {!! Form::label('tax_identification', 'Tax Identification', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('tax_identification', null, ['class' => 'form-control', 'data-mask' => '999-999-999', $disabled]) !!}
        </div>
    </div>
    <!-- End - Social Security & Tax Identification -->
    <!-- Start - PhilHealth & PagIbig -->
    <div class="form-group">
        {!! Form::label('philhealth', 'PhilHealth', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('philhealth', null, ['class' => 'form-control', 'data-mask' => '99-999999999-9', $disabled]) !!}
        </div>
        {!! Form::label('hdmf_pagibig', 'HDMF / PagIbig', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::text('hdmf_pagibig', null, ['class' => 'form-control', 'data-mask' => '9999 9999 9999', $disabled]) !!}
        </div>
    </div>
    <!-- End - PhilHealth & PagIbig -->
    <div class="hr-line-dashed"></div>

    @if ($disabled == '')
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            {!! Html::link(str_replace('/edit', '', \Request::path()), 'Cancel', ['class' => 'btn btn-white btn-xs']) !!}
            {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
        </div>
    </div>
    @else
        @if($loggedUser->hasAccess(\Request::segment(1).'.personal-details.update'))
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                {!! Html::link(\Request::path().'/edit', 'Modify', ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
        </div>
        @endif
    @endif
{!! Form::close() !!}