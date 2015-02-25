@extends('master.default')

@section('content')
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
                    <div class="">
                        <a id="addEmployee" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th class="fix-width">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @if(count($employees))
                                @foreach($employees as $employee)
                                    <tr id="timelog_{{$employee->id}}">
                                        <td>{{ $employee->first_name ? $employee->first_name . ' ' . $employee->last_name : '' }}</td>
                                        <td> </td>
                                        <td> {{ $employee->getTimeLog($date)['time_in'] }} </td>
                                        <td> {{ $employee->getTimeLog($date)['time_out'] }} </td>
                                        <td>
                                            <button rel="edit" id="{{$employee->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            <button rel="delete" id="{{$employee->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
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