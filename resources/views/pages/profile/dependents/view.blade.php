@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
            {!! HRis\Eloquent\Navlink::profileLinks($pim) !!}
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Assigned Dependents</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if($logged_user->hasAccess(\Request::segment(1).'.dependents.create'))
                    <div class="">
                        <a id="addDependent" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Relationship</th>
                                    <th>Birth Date</th>
                                    <th class="fix-width">Action</th>
                                </tr>
                            </thead>

                            <tbody id="dependentsBody">
                                @if(count($dependents))
                                    @foreach($dependents as $dependent)
                                    <tr class="dependentsList" id="dependent_{{$dependent->id}}">
                                        <td>{{ $dependent->first_name }} {{$dependent->middle_name}} {{ $dependent->last_name }}</td>
                                        <td>{{ HRis\Eloquent\Relationship::whereId($dependent->relationship_id)->pluck('name') }}</td>
                                        <td>{{ $dependent->birth_date }}</td>
                                        <td>
                                            @if($logged_user->hasAccess(\Request::segment(1).'.dependents.update'))
                                            <button rel="edit" id="{{$dependent->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            @endif
                                            @if($logged_user->hasAccess(\Request::segment(1).'.dependents.delete'))
                                            <button rel="delete" id="{{$dependent->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No dependents listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Modal -->

        <div class="modal fade" id="dependentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="myModalLabel">Dependent Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('employee_id', $employee->id) !!}
                            {!! Form::hidden('dependent_id', '', ['id' => 'dependent_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'dependentForm']) !!}

                            <div class="form-group">
                                {!! Form::label('first_name', 'First Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('middle_name', 'Middle Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('middle_name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('last_name', 'Last Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('last_name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('relationship_id', 'Relationship', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::select('relationship_id', HRis\Eloquent\Relationship::listsWithPlaceholder('name', 'id'), null, ['class' => 'form-control chosen-select']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('birth_date', 'Birth Date', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>{!! Form::text('birth_date', null, ['class' => 'form-control', 'data-mask' => '9999-99-99']) !!}
                                    </div>
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

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            function editRecord(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/' + '{{\Request::path()}}',
                    data: { id: dataId }
                }).done(function( response ) {

                    var dependent = jQuery.parseJSON(response);

                    // Set fields

                    $('#dependent_id').val(dependent.id);
                    $('#first_name').val(dependent.first_name);
                    $('#middle_name').val(dependent.middle_name);
                    $('#last_name').val(dependent.last_name);
                    $('#relationship_id').val(dependent.relationship_id);
                    $('#birth_date').val(dependent.birth_date);

                    $('.chosen-select').trigger("chosen:updated");

                    $("#dependentForm").attr("value", "PATCH");
                    $('#dependentModal').modal('toggle');
                });
            }

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/' + '{{\Request::path()}}',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#dependent_' + dataId).remove();

                        if($('.dependentsList').length == 0){
                            $('#dependentsBody').append('<tr><td colspan="4">No dependents listed</td></tr>');
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

            // Chosen
            $('.chosen-select').chosen({width:'100%'});

            $('#addDependent').click(function () {

                $('#first_name').val('');
                $('#middle_name').val('');
                $('#last_name').val('');
                $('#relationship_id').val(0);
                $('#birth_date').val('');

                $('.chosen-select').trigger("chosen:updated");

                $("#dependentForm").attr("value", "POST");
                $('#dependentModal').modal('toggle');
            });

            // Date picker
            $('#datepicker_birth_date .input-group.date').datepicker({
                todayBtn: "linked",
                format: 'yyyy-mm-dd',
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
        });
    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
