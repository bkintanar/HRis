@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">

        {!! HRis\TablePresenter::display($logged_user, $table) !!}

        <!-- Modal -->
        <div class="modal fade" id="work_shift_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Work Shift Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('work_shift_id', '', ['id' => 'work_shift_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'work_shift_form']) !!}

                            <div class="form-group">
                                {!! Form::label('class', 'Class', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('work_shift_date_range', 'Work Hours', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    <div class='input-group input-daterange input-full-width' id='timepicker'>
                                        {!! Form::text('from_time', null, ['class' => 'input-sm form-control', 'data-mask' => '99:99:00', 'id' => 'from_time']) !!}
                                        <span class="input-group-addon">to</span>
                                        {!! Form::text('to_time', null, ['class' => 'input-sm form-control', 'data-mask' => '99:99:00', 'id' => 'to_time']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('duration', 'Duration', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('duration', null, ['class' => 'form-control']) !!}
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
@stop

@section('custom_css')

    {!! Html::style('/css/plugins/datetimepicker/datetimepicker.min.css') !!}

    {!! Html::style('/css/plugins/datepicker/datepicker3.css') !!}

@stop

@section('custom_js')
    <!-- Moment -->
    {!! Html::script('/js/plugins/moment/moment.js') !!}
    <!-- Data picker -->
    {!! Html::script('/js/plugins/datetimepicker/datetimepicker.js') !!}
    <!-- Input Mask-->
    {!! Html::script('/js/plugins/jasny/jasny-bootstrap.min.js') !!}

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            function editRecord(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/get-work-shift',
                    data: { id: dataId }
                }).done(function( response ) {

                    var work_shift = jQuery.parseJSON(response);

                    // Set fields

                    $('#work_shift_id').val(work_shift.id);
                    $('#name').val(work_shift.name);
                    $('#from_time').val(work_shift.from_time);
                    $('#to_time').val(work_shift.to_time);
                    $('#duration').val(work_shift.duration);

                    $("#work_shift_form").attr("value", "PATCH");
                    $('#work_shift_modal').modal('toggle');
                });
            }

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/delete-work-shift',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#work_shift_' + dataId).remove();

                        if($('.work_shifts_list').length == 0){
                            $('#work_shifts_body').append('<tr><td colspan="4">No work shifts listed</td></tr>');
                        }
                    }
                    else
                    {
                        // failed
                    }
                });
            }

            $('.btn-xs').click(function(){

                var action = $(this).attr('rel');

                switch (action) {
                    case 'edit'   : editRecord($(this).attr('id'));
                        break;
                    case 'delete' : deleteRecord($(this).attr('id'));
                        break;
                }
            });

            $('#add_work_shift').click(function () {

                $('#name').val('');
                $('#from_time').val('');
                $('#to_time').val('');
                $('#duration').val('');

                $("#work_shift_form").attr("value", "POST");
                $('#work_shift_modal').modal('toggle');
            });

            // Time picker
            $('#from_time').datetimepicker({
                format: 'HH:mm:ss',
                pickDate: false,
                useSeconds: true,
                use24hours: true,
                minuteStepping: 30
            });
            $('#to_time').datetimepicker({
                format: 'HH:mm:ss',
                pickDate: false,
                useSeconds: true,
                use24hours: true,
                minuteStepping: 30
            });
        });
    </script>

@stop
