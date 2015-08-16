@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
            {!! Navlink::profileLinks($pim) !!}
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Job Details</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    {!! Form::model($employee, ['method' => 'PATCH', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('employee_id', $employee->id) !!}

                            <!-- End - Employment Commencement -->
                    <div class="form-group">
                        <label for="job_title_id" class="col-md-2 control-label">Job Title</label>
                        <div class="col-sm-4">
                            {!! Form::select('job_title_id', HRis\Eloquent\JobTitle::lists('name', 'id'), isset($employee->jobHistory()->job_title_id) ? $employee->jobHistory()->job_title_id : 0, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select form-fields', 'disabled' => 'disabled']) !!}
                        </div>

                        <label for="employment_status_id" class="col-md-2 control-label">Employment Status</label>
                        <div class="col-sm-4">
                            {!! Form::select('employment_status_id', HRis\Eloquent\EmploymentStatus::lists('name', 'id'), isset($employee->jobHistory()->employment_status_id) ? $employee->jobHistory()->employment_status_id : 0, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select form-fields', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                    <!-- End - Job Details -->

                    <div class="form-group">

                        <label for="department_id" class="col-md-2 control-label">Department</label>
                        <div class="col-sm-4">
                            {!! Form::select('department_id', HRis\Eloquent\Department::lists('name', 'id'), isset($employee->jobHistory()->department_id) ? $employee->jobHistory()->department_id : 0, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select form-fields', 'disabled' => 'disabled']) !!}
                        </div>

                        <label for="effective_date" class="col-md-2 control-label">Effective Date</label>
                        <div class="col-md-4" id="datepicker">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('effective_date', isset($employee->jobHistory()->effective_date) ? $employee->jobHistory()->effective_date->toDateString() : null, ['class' => 'form-control form-fields', 'data-mask' => '9999-99-99', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>

                    </div>

                    <div class="form-group">

                        <label for="" class="col-md-2 control-label">Location</label>
                        <div class="col-sm-4">
                            {!! Form::select('location_id', HRis\Eloquent\Location::lists('name', 'id'), isset($employee->jobHistory()->location_id) ? $employee->jobHistory()->location_id : 0, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select form-fields', 'disabled' => 'disabled']) !!}
                        </div>

                    </div>

                    <div class="form-group">

                        <label for="" class="col-md-2 control-label">Comments</label>
                        <div class="col-sm-10">
                            {!! Form::textarea('comments', null, ['class' => 'form-control form-fields', 'rows' => '3', 'disabled' => 'disabled', 'style' => 'resize:vertical;']) !!}
                        </div>


                    </div>

                    <div class="hr-line-dashed"></div>
                    <!-- End - Contact -->

                    <h4>Employment Commencement</h4><br />
                    <div class="form-group">
                        <label for="joined_date" class="col-md-2 control-label">Joined Date</label>
                        <div class="col-md-4" id="datepicker">
                            <div class="input-group date" id="data_1">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('joined_date', $employee->joined_date ? $employee->joined_date->toDateString() : null, ['class' => 'form-control form-fields', 'data-mask' => '9999-99-99', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>

                        <label for="probation_end_date" class="col-md-2 control-label">Probation End Date</label>
                        <div class="col-md-4" id="datepicker">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('probation_end_date', $employee->probation_end_date ? $employee->probation_end_date->toDateString() : null, ['class' => 'form-control form-fields', 'data-mask' => '9999-99-99', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="permanency_date" class="col-md-2 control-label">Date of Permanency</label>
                        <div class="col-md-4" id="datepicker">
                            <div class="input-group date" id="data_1">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('permanency_date', $employee->permanency_date ? $employee->permanency_date->toDateString() : null, ['class' => 'form-control form-fields', 'data-mask' => '9999-99-99', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>
                    </div>
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
        {!! TablePresenter::display($logged_user, $table) !!}
    </div>
@if ($custom_field_sections)
    @include('pages.profile.partials.custom-fields')
@endif

@stop

@section('custom_js')

    {!! Html::script('/js/custom_datepicker.js') !!}
    {!! Html::script('/js/notification.js') !!}

    <script>

        function deleteAction()
        {
            if($('.job_history_list').length < 2){
                $('.action').remove();
            }
        }

        function disableButton(status)
        {
            $('#save-button').attr('disabled', status);
        }

        function getValues()
        {
            searchIDs = new Array();
            var i = 0;
            $('.form-fields').each(function () {
                searchIDs[i] = $(this).val();
                i++;
            });

            return searchIDs.toString();
        }

        $(document).ready(function () {

            var defaults;

            defaults = getValues();
            deleteAction();
            disableButton(true);

            $('.form-fields').change(function(){
                var changes = getValues();
                if(changes !== defaults)
                {
                    disableButton(false);
                }
                else
                {
                    disableButton(true);
                }
            });

            // Date picker
            $('#datepicker .input-group.date').datepicker({
                todayBtn: "linked",
                format: 'yyyy-mm-dd',
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $('.chosen-select').chosen();

            $('.btn-xs').click(function(){

                var dataId = $(this).attr('id');

                $.ajax({
                    type: "DELETE",
                    url: '/ajax/' + '{{Request::path()}}',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        window.location = "?success=1";
                    }
                });

            });

            $('.modify-form').click(function() {
                $('.save-form').css('display', '');
                $('.modify-form').css('display', 'none');
                $('.form-control').prop('disabled', false);

                $('.chosen-select').trigger('chosen:updated');
                $('.i-checks').iCheck('enable');

            });

            $('.cancel-form').click(function() {
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
