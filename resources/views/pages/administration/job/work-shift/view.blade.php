@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Work Shifts</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    @if($logged_user->hasAccess('admin.job.work-shifts.create'))
                    <div class="">
                        <a id="addJobTitle" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Work Shift</th>
                                    <th>Duration</th>
                                    <th class="fix-width">Action</th>
                                </tr>
                            </thead>

                            <tbody id="workShiftsBody">
                                @if(count($workShifts))
                                    @foreach($workShifts as $workShift)
                                    <tr class="workShiftsList" id="workShift_{{$workShift->id}}">
                                        <td>{{ $workShift->id }}</td>
                                        <td>{{ $workShift->name }}</td>
                                        <td>{{ $workShift->duration }} hours</td>
                                        <td>
                                            @if($logged_user->hasAccess('admin.job.work-shifts.update'))
                                            <button rel="edit" id="{{$workShift->id}}" class="btn btn-primary btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            @endif
                                            @if($logged_user->hasAccess('admin.job.work-shifts.delete'))
                                            <button rel="delete" id="{{$workShift->id}}" class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No work shifts listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Modal -->
        <div class="modal fade" id="workShiftModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="myModalLabel">Work Shift Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('work_shift_id', '', ['id' => 'work_shift_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'workShiftForm']) !!}

                            <div class="form-group">
                                {!! Form::label('class', 'Class', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('workShiftDateRange', 'Work Hours', ['class' => 'col-md-3 control-label']) !!}
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

                    $("#workShiftForm").attr("value", "PATCH");
                    $('#workShiftModal').modal('toggle');
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
                        $('#workShift_' + dataId).remove();

                        if($('.workShiftsList').length == 0){
                            $('#workShiftsBody').append('<tr><td colspan="4">No work shifts listed</td></tr>');
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

            $('#addJobTitle').click(function () {

                $('#name').val('');
                $('#from_time').val('');
                $('#to_time').val('');
                $('#duration').val('');

                $("#workShiftForm").attr("value", "POST");
                $('#workShiftModal').modal('toggle');
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
