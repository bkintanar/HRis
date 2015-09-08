@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
        {!! Menu::profile() !!}
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Personal Details</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    {!! Form::model($employee, ['method' => 'PATCH', 'url' => Request::path(), 'class' => 'form-horizontal', 'onSubmit' => 'checkEmployeeId()', 'id' => 'personalDetailsForm']) !!}
                    {!! Form::hidden('user[id]') !!}
                    {!! Form::hidden('id') !!}
                    <!-- Start - Full Name -->
                    <div class="form-group">
                        {!! Form::label('first_name', 'Full Name', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::text('first_name', null, ['class' => 'form-control', 'required', 'disabled' => 'disabled']) !!}
                            <span class="help-block m-b-none">First Name</span>
                        </div>
                        <div class="col-md-2">
                            {!! Form::text('middle_name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                            <span class="help-block m-b-none">Middle Name</span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::text('last_name', null, ['class' => 'form-control', 'required', 'id' => 'last_name', 'disabled' => 'disabled']) !!}
                            <span class="help-block m-b-none">Last Name</span>
                        </div>
                    </div>
                    <!-- End - Full Name -->
                    <div class="hr-line-dashed"></div>
                    <!-- Start - Employee Id & Face Id -->
                    <div class="form-group">
                        {!! Form::label('employee_id', 'Employee Id', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('employee_id', null, ['class' => 'form-control', 'data-mask' => $employee_id_prefix . '9999', 'required' => 'required', 'disabled' => 'disabled']) !!}
                        </div>
                        {!! Form::label('face_id', 'Face Id', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('face_id', null, ['class' => 'form-control', 'data-mask' => '999', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                    <!-- End - Employee Id & Face Id -->
                    <div class="hr-line-dashed"></div>
                    <!-- Start - Gender & Marital Status -->
                    <div class="form-group">
                        {!! Form::label('gender', 'Gender', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4">
                            <label class="radio-inline i-checks">
                                {!! Form::radio('gender', 'M', null, ['disabled' => 'disabled']) !!} Male
                            </label>
                            <label class="radio-inline i-checks">
                                {!! Form::radio('gender', 'F', null, ['disabled' => 'disabled']) !!} Female
                            </label>
                        </div>

                        {!! Form::label('marital_status_id', 'Marital Status', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::select('marital_status_id', HRis\Eloquent\MaritalStatus::lists('name', 'id'), $employee->marital_status_id, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                    <!-- End - Gender & Marital Status -->
                    <!-- Start - Nationality & DOB -->
                    <div class="form-group">
                        {!! Form::label('nationality_id', 'Nationality', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::select('nationality_id', HRis\Eloquent\Nationality::lists('name', 'id'), $employee->nationality_id, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select', 'disabled' => 'disabled']) !!}
                        </div>
                        {!! Form::label('birth_date', 'Date of Birth', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4" id="datepicker_birth_date">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('birth_date', $employee->birth_date ? $employee->birth_date->toDateString() : null, ['class' => 'form-control', 'data-mask' => '9999-99-99', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>
                    </div>
                    <!-- End - Nationality & DOB -->
                    <div class="hr-line-dashed"></div>
                    <!-- Start - Social Security & Tax Identification -->
                    <div class="form-group">
                        {!! Form::label('social_security', 'Social Security', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('social_security', null, ['class' => 'form-control', 'data-mask' => '99-9999999-9', 'disabled' => 'disabled']) !!}
                        </div>
                        {!! Form::label('tax_identification', 'Tax Identification', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('tax_identification', null, ['class' => 'form-control', 'data-mask' => '999-999-999', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                    <!-- End - Social Security & Tax Identification -->
                    <!-- Start - PhilHealth & PagIbig -->
                    <div class="form-group">
                        {!! Form::label('philhealth', 'PhilHealth', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('philhealth', null, ['class' => 'form-control', 'data-mask' => '99-999999999-9', 'disabled' => 'disabled']) !!}
                        </div>
                        {!! Form::label('hdmf_pagibig', 'HDMF / PagIbig', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('hdmf_pagibig', null, ['class' => 'form-control', 'data-mask' => '9999 9999 9999', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                    <!-- End - PhilHealth & PagIbig -->
                    <div class="hr-line-dashed"></div>

                    <div class="form-group save-form" style="display:none;">
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Html::link('#0', 'Cancel', ['class' => 'btn btn-white btn-xs cancel-form']) !!}
                            {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
                        </div>
                    </div>
                    @if($logged_user->hasAccess(Request::segment(1).'.personal-details.update'))
                        <div class="form-group modify-form">
                            <div class="col-sm-4 col-sm-offset-2">
                                {!! Html::link('#0', 'Modify', ['class' => 'btn btn-primary btn-xs']) !!}
                            </div>
                        </div>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @if ($custom_field_sections)
        @include('pages.profile.partials.custom-fields')
    @endif
    <!-- Modal -->
    <div class="modal fade" id="avatar_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>

                    <h4 class="modal-title" id="myModalLabel">Add Avatar</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="image-crop">
                                <img src='/img/profile/{!! isset($employee->avatar) ? $employee->avatar : "default/0.png" !!}'>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="btn-zoom">
                                <button class="btn btn-danger btn-xs" id="zoomOut" type="button">-</button>
                                <button class="btn btn-warning btn-xs" id="zoomIn" type="button">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="modal-close btn-sm" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancel</span></button>

                            <label title="Upload image file" for="inputImage" class="btn btn-white btn-sm">
                                <input type="file" accept="image/*" name="file" id="inputImage" class="hide">
                                Upload new image
                            </label>

                            <button class="btn btn-primary btn-sm" id="crop" type="button">Crop And Save</button>

                        </div>
                    </div>
                </div>
                <!--//Cropper-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@stop

@section('custom_css')

    {!! Html::style('/css/plugins/cropper/cropper.min.css') !!}

@stop

@section('custom_js')
    <!-- Cropper -->
    {!! Html::script('/js/plugins/cropper/cropper.min.js') !!}
    {!! Html::script('/js/custom_datepicker.js') !!}
    {!! Html::script('/js/notification.js') !!}

    <script>
        function checkEmployeeId (){

            var employee_id = $('#employee_id').val();
            var original_employee_id = '{!! $employee->employee_id !!}';

            // pim/employee-list/{id}/personal-details
            if (original_employee_id != employee_id && (window.location.pathname).indexOf('/pim/') >= 0)
            {
                var action = $('#personalDetailsForm').attr('action');
                var action_array = action.split('/');

                action_array[action_array.length-2] = employee_id;

                $('#personalDetailsForm').attr('action', action_array.join('/'));
            }
        }

        $(document).ready(function () {

            // iCheck
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            // Cropper
            var $image = $(".image-crop > img");
            $($image).cropper({
              aspectRatio: 1,
              strict: false,
              guides: false,
              highlight: false,
              dragCrop: false,
              movable: true,
              resizable: true,
              zoom: 0.2,
            });

            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function() {
                    var fileReader = new FileReader(),
                             files = this.files,
                             file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $inputImage.val("");
                            $image.cropper("reset", true).cropper("replace", this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }

            $("#crop").click(function() {
                $.ajax({
                    "type": "POST",
                    "url": "/ajax/upload-profile-image",
                    "data": {
                        "employeeId": {!! $employee->id !!},
                    "imageData": $image.cropper("getDataURL"),
                    "_token": $('input[name=_token]').val()
                    }
                }).done(function(o) {

                    $('#avatar_modal').modal('toggle');

                    // If changing own photo, change photo in the navigation as well
                    @if ($employee->id == $logged_user->employee->id)
                        $('#profile-image-nav').delay(1000).attr('src', '/img/profile/' + o);
                    @endif

                    // Change the employee's photo with the uploaded one
                    $('#profile-image').delay(1000).attr('src', '/img/profile/' + o);
                });
            });

            $("#zoomIn").click(function() {
                $image.cropper("zoom", 0.1);
            });

            $("#zoomOut").click(function() {
                $image.cropper("zoom", -0.1);
            });

            // Chosen
            $('.chosen-select').chosen({width:'100%'});

            $('#add_avatar').click(function () {

                $('#avatar_modal').modal('toggle');
            });

            $('.modify-form').click(function() {
                $('.avatar').css('display', '');
                $('.job-title').css('display', 'none');

                $('.save-form').css('display', '');
                $('.modify-form').css('display', 'none');
                $('.form-control').prop('disabled', false);

                $('.chosen-select').trigger('chosen:updated');
                $('.i-checks').iCheck('enable');

            });

            $('.cancel-form').click(function() {
                $('.avatar').css('display', 'none');
                $('.job-title').css('display', '');

                $('.save-form').css('display', 'none');
                $('.modify-form').css('display', '');
                $('.form-control').prop('disabled', true);

                $('.chosen-select').trigger('chosen:updated');
                $('.i-checks').iCheck('disable');
            });
        });
    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
