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
                                    @{{ summaryReport.total_hours }} hours
                                </span>
                                Total Hours
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    @{{ summaryReport.late }} hours
                                </span>
                                Late
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    @{{ summaryReport.undertime }} hours
                                </span>
                                Undertime
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    @{{ summaryReport.overtime }} hours
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
                                    <th>Time In</th>
                                    <th>Time Out</th>
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
                                    <td>@{{ timelog.in | dateFormat }}</td>
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
        <!-- Modal -->
        <div class="modal inmodal fade" id="edit_timelog" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">Edit timelog</h4>
                    </div>
                    <form class="form-horizontal">
                        <div class="modal-body">
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
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-white" data-dismiss="modal" type="button">Close</button>
                            <button 
                                class="btn btn-primary" 
                                data-dismiss="modal" 
                                v-on="click: updateTimelog">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('sub_header')
<div class="row wrapper border-bottom">
    <div id="reportrange" 
         class="pull-right" 
         style="cursor: pointer; padding: 10px 0;margin-right:6px">
        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;&nbsp;<span></span> <b class="caret"></b>
    </div>
</div>
@stop
@section('custom_css')
    {!! Html::style('/css/plugins/dataTables/dataTables.bootstrap.css') !!}
    {!! Html::style('/css/plugins/dataTables/dataTables.responsive.css') !!}
    {!! Html::style('/js/plugins/jquery.filthypillow/jquery.filthypillow.css') !!}
    {!! Html::style('//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css') !!}
@stop
@section('custom_js')
    {!! Html::script('/js/notification.js') !!}
    {!! Html::script('//cdn.jsdelivr.net/momentjs/latest/moment.min.js') !!}
    {!! Html::script('//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js') !!}
    {!! Html::script('/js/attendance.js') !!}
    {!! Html::script('/js/plugins/jquery.filthypillow/jquery.filthypillow.min.js') !!}
@stop