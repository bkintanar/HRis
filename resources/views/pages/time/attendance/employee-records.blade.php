@extends('master.default')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Employee's Attendance</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    {!! Form::open(['method' => 'POST', 'url' => Request::path()]) !!}
                    <div class="form-group">
                        {!! Form::label('employee_name', 'Employee Name', ['class' => 'control-label']) !!}
                        {!! Form::select('employee_id', HRis\Eloquent\Employee::get()->lists('full_name', 'id'), $employee_id, ['class' => 'form-control chosen-select']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('work_date', 'Work Date', ['class' => 'control-label']) !!}
                        <div id="datepicker_work_date">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('work_date', $work_date ? : Carbon::now()->format('F Y'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            {!! Form::submit('View records', ['class' => 'btn btn-primary btn-xs btn-block']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Summary Report</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <ul class="list-group clear-list">
                        <li class="list-group-item fist-item">
                            <span class="pull-right">
                                0 hours
                            </span>
                            Total Hours
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right">
                                0 hours
                            </span>
                            Late
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right">
                                0 hours
                            </span>
                            Undertime
                        </li>
                        <li class="list-group-item">
                            <span class="pull-right">
                                0 hours
                            </span>
                            Overtime
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
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
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Hours</th>
                                <th class="fix-width">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(isset($attendance))
                                @foreach($attendance as $key => $row)
                                    @if ($row == null)
                                    <tr>
                                        <td>{{ Carbon::parse($key)->format('D, F j, Y') }}</td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>
                                            <button rel="edit" id="" class="btn btn-primary btn-xs btn-warning"
                                                    name="edit" title="Edit" type="button"><i class="fa fa-edit"></i>
                                            </button>
                                            <button rel="delete" id="" class="btn btn-primary btn-xs btn-danger"
                                                    name="delete" title="Delete" type="button"><i
                                                        class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    @else
                                    <tr id="timelog_{{$row->id}}">
                                        <td>{{ Carbon::parse($row->work_date)->format('D, F j, Y') }}</td>
                                        <td> {{ $row->in_time ? Carbon::parse($row->in_time)->format('h:i A') : '-- No Login --' }} </td>
                                        <td> {{ $row->out_time ? Carbon::parse($row->out_time)->format('h:i A') : '-- No Logout --' }} </td>
                                        <td>
                                            <button rel="edit" id="{{$row->id}}"
                                                    class="btn btn-primary btn-xs btn-warning" name="edit" title="Edit"
                                                    type="button"><i class="fa fa-edit"></i></button>
                                            <button rel="delete" id="{{$row->id}}"
                                                    class="btn btn-primary btn-xs btn-danger" name="delete"
                                                    title="Delete" type="button"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="5">No timelogs listed</td>
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

@section('custom_js')

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
