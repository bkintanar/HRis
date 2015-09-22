@extends('master.default')

@section('content')
<div class="row animated fadeInDown">
    <div class="col-lg-4">
        <div class="ibox float-e-margins" v-show="isView('calendar')">
            <div class="ibox-title">
                <h5>Add to calendar</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <textarea rows="3" class="form-control" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn-block btn btn-primary btn-xs">Add</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="hr-line-dashed"></div>
                        <div id='external-events'>
                            <p>Drag and drop into callendar.</p>
                            <div class='external-event navy-bg'>Company teambuilding</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox float-e-margins" v-show="isView('form')">
            <div class="ibox-title">
                <h5>Upcoming Events</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content no-padding">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Company Teambuilding</strong>
                        <br>
                        <small><span class="text-muted">on</span> Tuesday, Oct 20, 2015</small>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ibox float-e-margins" v-show="isView('form')">
            <div class="ibox-title">
                <h5>Upcoming Holidays</h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content no-padding">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Christmas</strong>
                        <span class="pull-right badge badge-warning">Special</span>
                        <br>
                        <small><span class="text-muted">on</span> Dec 24 - 25, 2015</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="ibox float-e-margins" v-show="isView('calendar')">
            <div class="ibox-title">
                <h5>Holidays and Events</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div id="calendar"></div>
            </div>
        </div>
        <div class="ibox float-e-margins" v-show="isView('form')">
            <div class="ibox-title">
                <h5>
                    Add to calendar
                </h5>
                <div class="ibox-tools">
                    <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form method="get" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Title">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-10">
                            <div class="checkbox i-checks">
                                <label>
                                    <input name="calendar_event" type="radio" value="event" checked> <i></i>
                                    Event
                                </label>
                            </div>
                            <div class="checkbox i-checks">
                                <label>
                                    <input name="calendar_event" type="radio" value="holiday"> <i></i>
                                    Holiday
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Period</label>
                        <div class="col-sm-10">
                            <input type="time" class="form-control">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-white" type="submit">Cancel</button>
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('sub_header')
<div class="row wrapper border-bottom">
    <div class="pull-right">
        <a  href="#" 
            class="btn btn-link"
            data-toggle="tooltip" 
            data-placement="bottom" 
            title="Form"
            v-class="active: isView('form')"
            v-on="click: setView('form')"
            >
            <i class="fa fa-list-ul"></i>
        </a>
        <a  href="#" 
            class="btn btn-link"
            data-toggle="tooltip" 
            data-placement="bottom" 
            title="Calendar"
            v-class="active: isView('calendar')"
            v-on="click: setView('calendar')"
            >
            <i class="fa fa-calendar"></i>
        </a>
    </div>
</div>
@stop
@section('custom_css')
{!! Html::style('/css/plugins/fullcalendar/fullcalendar.css') !!}
{!! Html::style('/css/plugins/fullcalendar/fullcalendar.print.css', ['media' => 'print']) !!}
@stop
@section('custom_js')
<!-- jQuery UI custom -->
{!! Html::script('/js/jquery-ui.custom.min.js') !!}

<!-- Full Calendar -->
{!! Html::script('/js/plugins/fullcalendar/moment.min.js') !!}
{!! Html::script('/js/plugins/fullcalendar/fullcalendar.min.js') !!}
{!! Html::script('/js/holidays_and_events.js') !!}

<script>
    $(document).ready(function() {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        /* initialize the external events
         -----------------------------------------------------------------*/
        $('#external-events div.external-event').each(function() {
            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 1111999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
        /* initialize the calendar
         -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            events: [
                {
                    title: 'All Day Event',
                    start: new Date(y, m, 1)
                },
                {
                    title: 'Long Event',
                    start: new Date(y, m, d-5),
                    end: new Date(y, m, d-2),
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d-3, 16, 0),
                    allDay: false,
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d+4, 16, 0),
                    allDay: false
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d+1, 19, 0),
                    end: new Date(y, m, d+1, 22, 30),
                    allDay: false
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/'
                }
            ],
        });
    });
</script>
@stop