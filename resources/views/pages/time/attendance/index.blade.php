@extends('master.default')

@section('content')
    <div class="row">
        <div class="col-md-3">
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
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Timesheet</h5>
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
                                            <button rel="edit" class="btn btn-primary btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-edit"></i></button>
                                            <button rel="delete" class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="button"><i class="fa fa-times"></i></button>
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
@stop

@section('custom_css')
    {!! Html::style('/css/plugins/dataTables/dataTables.bootstrap.css') !!}
    {!! Html::style('/css/plugins/dataTables/dataTables.responsive.css') !!}
@stop
@section('custom_js')

    {!! Html::script('/js/notification.js') !!}
    {!! Html::script('/js/plugins/moment/moment.js') !!}
    
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
        });
    </script>
@stop