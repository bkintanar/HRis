@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
            {!! Menu::profile() !!}

            {!! TablePresenter::display($logged_user, $table) !!}

        <!-- Modal -->
        <div class="modal fade" id="dependent_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Dependent Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', Request::path()), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('employee_id', $employee->id) !!}
                            {!! Form::hidden('dependent_id', '', ['id' => 'dependent_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'dependent_form']) !!}

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
                                    {!! Form::select('relationship_id', HRis\Eloquent\Relationship::lists('name', 'id'), null, ['data-placeholder' => '--- Select ---', 'class' => 'form-control chosen-select']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('birth_date', 'Birth Date', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9" id="datepicker">
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
    @if ($custom_field_sections)
        @include('pages.profile.partials.custom-fields')
    @endif
@stop

@stop

@section('custom_js')

    {!! Html::script('/js/notification.js') !!}
    {!! Html::script('/js/custom_datepicker.js') !!}

    <script>
        $(document).ready(function () {

            function editRecord(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/' + '{{Request::path()}}',
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

                    $("#dependent_form").attr("value", "PATCH");
                    $('#dependent_modal').modal('toggle');
                });
            }

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/' + '{{Request::path()}}',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#dependent_' + dataId).remove();

                        if($('.dependents_list').length == 0){
                            $('#dependents_body').append('<tr><td colspan="4">No dependents listed</td></tr>');
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

            $('#add_dependent').click(function () {

                $('#first_name').val('');
                $('#middle_name').val('');
                $('#last_name').val('');
                $('#relationship_id').val(0);
                $('#birth_date').val('');

                $('.chosen-select').trigger("chosen:updated");

                $("#dependent_form").attr("value", "POST");
                $('#dependent_modal').modal('toggle');
            });

            // Date picker
            $('#datepicker .input-group.date').datepicker({
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
