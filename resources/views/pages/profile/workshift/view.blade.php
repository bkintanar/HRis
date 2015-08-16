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
                    {!! Form::model($employee, ['method' => 'PATCH', 'url' => str_replace('/edit', '', Request::path()), 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('employee_id', $employee->id) !!}

                    <div class="form-group">

                        <label for="" class="col-md-2 control-label">Work Shift</label>
                        <div class="col-sm-4">
                            {!! Form::select('work_shift_id', HRis\Eloquent\WorkShift::lists('name', 'id'), $employee->employeeWorkShift()->first() ? $employee->employeeWorkShift()->first()->work_shift_id : 0, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select form-fields', 'disabled' => 'disabled']) !!}
                        </div>

                        <label for="effective_date" class="col-md-2 control-label">Effective Date</label>
                        <div class="col-md-4" id="datepicker">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('effective_date', isset($employee->jobHistory()->effective_date) ? $employee->jobHistory()->effective_date->toDateString() : null, ['class' => 'form-control form-fields', 'data-mask' => '9999-99-99', 'disabled' => 'disabled']) !!}
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
        @include('pages.profile.workshift.work-shifts')
    </div>
    @if ($custom_field_sections)
        @include('pages.profile.partials.custom-fields')
    @endif
@stop

@section('custom_js')

    {!! Html::script('/js/custom_datepicker.js') !!}

    <script>

        function deleteAction()
        {
            if($('.WorkShiftList').length < 2){
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
