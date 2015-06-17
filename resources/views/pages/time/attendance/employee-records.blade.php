@extends('master.default')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Search Employee's Attendance</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    {!! Form::open(['method' => 'POST', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                    <div class="form-group">
                        {!! Form::label('employee_name', 'Employee Name', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4">
                            {!! Form::select('employee_id', HRis\Eloquent\Employee::get()->lists('full_name', 'id'), $employee_id, ['class' => 'form-control chosen-select']) !!}
                        </div>

                        {!! Form::label('work_date', 'Work Date', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-sm-4" id="datepicker_work_date">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('work_date', $work_date ? : Carbon::now()->format('F Y'), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                    </div>

                    <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                {!! Html::link(Request::path(), 'Cancel', ['class' => 'btn btn-white btn-xs']) !!}
                                {!! Form::submit('Search', ['class' => 'btn btn-primary btn-xs']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>View Attendance Record</h5>
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
                                <th>Work Date</th>
                                <th></th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th class="fix-width">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(isset($attendance))
                                @foreach($attendance as $key => $row)
                                    @if ($row == null)
                                    <tr>
                                        <td>{{ Carbon::parse($key)->format('D, F j, Y') }}</td>
                                        <td> </td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>
                                            <button rel="edit" id="" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            <button rel="delete" id="" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @else
                                    <tr id="timelog_{{$row->id}}">
                                        <td>{{ Carbon::parse($row->work_date)->format('D, F j, Y') }}</td>
                                        <td> </td>
                                        <td> {{ $row->in_time ? Carbon::parse($row->in_time)->format('h:i A') : '-- No Login --' }} </td>
                                        <td> {{ $row->out_time ? Carbon::parse($row->out_time)->format('h:i A') : '-- No Logout --' }} </td>
                                        <td>
                                            <button rel="edit" id="{{$row->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            <button rel="delete" id="{{$row->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No timelogs listed</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('custom_css')

    {!! Html::style('/css/plugins/datepicker/datepicker3.css') !!}
    {!! Html::style('/css/plugins/chosen/chosen.css') !!}

@stop

@section('custom_js')

    <!-- Data picker -->
    {!! Html::script('/js/plugins/datepicker/bootstrap-datepicker.js') !!}
    <!-- Input Mask-->
    {!! Html::script('/js/plugins/jasny/jasny-bootstrap.min.js') !!}
    <!-- Chosen -->
    {!! Html::script('/js/plugins/chosen/chosen.jquery.js') !!}

    <script>
        $(document).ready(function () {
            $('.chosen-select').chosen();

            // Date picker
            $('#datepicker_work_date .input-group.date').datepicker({
                format: "MM yyyy",
                viewMode: "months",
                minViewMode: "months",
                autoclose: true
            });
        });
    </script>
@stop
