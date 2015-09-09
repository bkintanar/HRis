@extends('master.default')

@section('content')
    <div id="app" class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Compose Timelog</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <h1 class="text-center">@{{ time }}</h1>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <a 
                                    href="#" 
                                    class="btn btn-primary" 
                                    v-on="click: timeIn">
                                    IN
                                </a>
                                <a 
                                    href="#" 
                                    class="btn btn-default" 
                                    v-el="out"
                                    v-on="click: timeOut"
                                    {{ $latest ? 'data-id='.$latest->id : '' }}>
                                    OUT
                                </a>
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
                                    @{{ totalHours }} hours
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
                        <small>(@{{ dateRange }})</small>
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
                                <tr v-show="! isTimelogLoaded">
                                    <td colspan="6" class="text-center">Loading...</td>
                                </tr>
                                <tr v-show="! timelogs.length && isTimelogLoaded">
                                    <td colspan="6" class="text-center">No records found</td>
                                </tr>
                                <tr v-repeat="timelog: timelogs">
                                    <td>@{{ timelog.created_at | dateFormat }}</td>
                                    <td>@{{ timelog.in | timeFormat }}</td>
                                    <td>@{{ timelog.out | timeFormat }}</td>
                                    <td>@{{ timelog.rendered_hours | decimalPlace }}</td>
                                    <td class="text-muted">
                                        <button 
                                            rel="edit"
                                            class="btn btn-primary btn-xs btn-warning" 
                                            data-toggle="tooltip" 
                                            data-placement="bottom" 
                                            title="Edit" 
                                            type="button"
                                            v-on="click: editTimelog(timelog)"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button 
                                            rel="delete"
                                            class="btn btn-primary btn-xs btn-danger" 
                                            data-toggle="tooltip"  
                                            data-placement="bottom" 
                                            title="Delete" 
                                            type="button"
                                            v-on="click: deleteTimelog(timelog)"
                                        >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
    {!! Html::script('/js/attendance.js') !!}
@stop