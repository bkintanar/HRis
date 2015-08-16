@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
            {!! Navlink::profileLinks($pim) !!}

            {!! TablePresenter::display($logged_user, $table) !!}

        <!-- Modal -->
        <div class="modal fade" id="emergency_contact_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Emergency Contact Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', Request::path()), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('employee_id', $employee->id) !!}
                            {!! Form::hidden('emergency_contact_id', '', ['id' => 'emergency_contact_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'emergency_contact_form']) !!}
                            <div class="form-group">
                                {!! Form::label('first_name', 'Full Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('middle_name', 'Middle Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('middle_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('last_name', 'Last Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('last_name', null, ['class' => 'form-control', 'required', 'id' => 'last_name']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('relationship_id', 'Relationship', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::select('relationship_id', HRis\Eloquent\Relationship::listsWithPlaceholder('name', 'id'), null, ['class' => 'form-control chosen-select']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('mobile_phone', 'Mobile', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('mobile_phone', null, ['class' => 'form-control', 'data-mask' => '0999 999 9999']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('home_phone', 'Home Telephone', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('home_phone', null, ['class' => 'form-control', 'data-mask' => '099 999 9999']) !!}
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

    <script>
        $(document).ready(function () {

            function editRecord(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/' + '{{Request::path()}}',
                    data: { id: dataId }
                }).done(function( response ) {

                    var emergency_contact = jQuery.parseJSON(response);

                    // Set fields

                    $('#emergency_contact_id').val(emergency_contact.id);
                    $('#first_name').val(emergency_contact.first_name);
                    $('#middle_name').val(emergency_contact.middle_name);
                    $('#last_name').val(emergency_contact.last_name);
                    $('#relationship_id').val(emergency_contact.relationship_id);
                    $('#home_phone').val(emergency_contact.home_phone);
                    $('#mobile_phone').val(emergency_contact.mobile_phone);

                    $('.chosen-select').trigger("chosen:updated");

                    $("#emergency_contact_form").attr("value", "PATCH");
                    $('#emergency_contact_modal').modal('toggle');
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
                        $('#emergency_contact_' + dataId).remove();

                        if($('.emergency_contacts_list').length == 0){
                            $('#emergency_contacts_body').append('<tr><td colspan="5">No emergency contacts listed</td></tr>');
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

            $('#add_emergency_contact').click(function () {

                $('#first_name').val('');
                $('#middle_name').val('');
                $('#last_name').val('');
                $('#relationship_id').val(0);
                $('#home_phone').val('');
                $('#mobile_phone').val('');

                $('.chosen-select').trigger("chosen:updated");

                $("#emergency_contact_form").attr("value", "POST");
                $('#emergency_contact_modal').modal('toggle');
            });
        });
    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop
