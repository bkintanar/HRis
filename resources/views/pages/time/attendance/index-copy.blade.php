@extends('master.default')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Compose Timelog</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <h1 id="time" class="text-center">--:--</h1>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <a id="in" href="#" class="btn btn-primary">IN</a>
                                <a id="out" href="#" class="btn btn-default" {{ $latest ? 'data-id='.$latest->id : '' }}>OUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Summary Report</h5>
                    </div>
                    <div class="ibox-content">
                        <ul class="list-group clear-list">
                            <li class="list-group-item fist-item">
                                <span class="pull-right">
                                    48 hours
                                </span>
                                Total Hours
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    0.48 hours
                                </span>
                                Late
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    0.22 hours
                                </span>
                                Undertime
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    12 hours
                                </span>
                                Overtime
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>
                        Timesheet
                        <small>(September)</small>
                    </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Hours</th>
                                    <th class="fix-width">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($timelogs))
                                    @foreach($timelogs as $timelog)
                                    <tr>
                                        <td class="date" {!! $timelog->created_at ? 'data-utc="'.$timelog->created_at.'"' :  '' !!}></td>
                                        <td class="time" {!! $timelog->in ? 'data-utc="'.$timelog->in.'"' :  '' !!}>--:--</td>
                                        <td class="time" {!! $timelog->out ? 'data-utc="'.$timelog->out.'"' : '' !!}>--:--</td>
                                        <td>{{ number_format($timelog->rendered_hours, 2) }}</td>
                                        <td class="text-muted">
                                            <button rel="edit" class="btn btn-primary btn-xs btn-warning edit" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-edit"></i></button>
                                            <button rel="delete" class="btn btn-primary btn-xs btn-danger remove" data-toggle="tooltip"  data-placement="bottom" title="Delete" type="button"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="5">No timelog listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {!! HRis\Services\Pagination::setupPagination($timelogs, $settings) !!}
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="edit_timelog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>

                    <h4 class="modal-title" id="my_modal_label">Edit Timelog</h4>
                </div>

                <div class="modal-body">
                    <form action="" class="form-horizontal">
                        <div class="form-group">
                            {!! Form::label('time_in', 'Time In', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('time_in', null, ['class' => 'form-control', 'placeholder' => 'Time In']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('time_out', 'Time Out', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('time_out', null, ['class' => 'form-control', 'placeholder' => 'Time Out']) !!}
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-white btn-xs" data-dismiss="modal" type="button">Close</button>
                    {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_css')
    {!! Html::style('/css/plugins/dataTables/dataTables.bootstrap.css') !!}
    {!! Html::style('/css/plugins/dataTables/dataTables.responsive.css') !!}
    {!! Html::style('//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css') !!}
@stop
@section('custom_js')
    {!! Html::script('/js/notification.js') !!}
    {!! Html::script('//cdn.jsdelivr.net/momentjs/latest/moment.min.js') !!}
    {!! Html::script('//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js') !!}
    <script>
        $(document).ready(function () {
            $('#in').on('click', function(e) {
                e.preventDefault();
                $.getJSON('/alert/time_in', function(settings, textStatus) {
                    swal(settings,
                        function(){
                            swal.disableButtons();
                            $.post('/ajax/time_in', function(data) {
                                swal(data.title, data.text);
                                location.reload();
                            });
                        }
                    );
                });
            });

            $('#out').on('click', function(e) {
                e.preventDefault();
                var data = {'id': $(this).data('id')};

                $.getJSON('/alert/time_out', function(settings, textStatus) {
                    swal(settings,
                        function(){
                            swal.disableButtons();
                            $.post('/ajax/time_out', data, function(data) {
                                swal(data.title, data.text);
                                location.reload();
                            });
                        }
                    );
                });
            });

            // iCheck
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $('.chosen-select').chosen();

            $.getJSON('/ajax/server_time', function(data, textStatus) {
                var format = 'h:mm:ss A',
                    local = moment.utc(data.server.date).toDate();

                setInterval(function(){
                    var time = moment(local).format(format);

                    $('#time').text(time);
                    local = moment(local).add(1, 'seconds').toDate();
                },1000);     
            });

            $('#data_4 .input-group.date').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true
            });
            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
            $(function() {
                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
                cb(moment().subtract(29, 'days'), moment());

                $('#reportrange').daterangepicker({
                    ranges: {
                       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                       'This Month': [moment().startOf('month'), moment().endOf('month')],
                       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);
            });
            $('.remove').on('click', function() {
                swal({
                    title: 'Are you sure?',
                    text: 'You want to delete this timelog', 
                    type: 'warning', 
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    closeOnConfirm: false 
                }, function() {
                    swal('Deleted!', 'Timelog successfully deleted.', 'success');
                });
            });

            $('.edit').on('click', function() {
                $('#edit_timelog').modal('show');
            });
        });
    </script>
@stop