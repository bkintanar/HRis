@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
            {!! \HRis\Eloquent\Navlink::profileLinks($pim) !!}
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>In case of Emergency</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if($loggedUser->hasAccess(\Request::segment(1).'.emergency-contacts.create'))
                    <div class="">
                        <a id="addEmergencyContact" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Relationship</th>
                                    <th>Home Telephone</th>
                                    <th>Mobile</th>
                                    <th class="fix-width">Action</th>
                                </tr>
                            </thead>

                            <tbody id="emergencyContactsBody">
                                @if(count($emergencyContacts))
                                    @foreach($emergencyContacts as $emergencyContact)
                                    <tr class="emergencyContactsList" id="emergencyContact_{{$emergencyContact->id}}">
                                        <td>{{ $emergencyContact->first_name }} {{$emergencyContact->middle_name}} {{ $emergencyContact->last_name }}</td>
                                        <td>{{ HRis\Eloquent\Relationship::whereId($emergencyContact->relationship_id)->pluck('name') }}</td>
                                        <td>{{ $emergencyContact->home_phone }}</td>
                                        <td>{{ $emergencyContact->mobile_phone }}</td>
                                        <td>
                                            @if($loggedUser->hasAccess(\Request::segment(1).'.emergency-contacts.update'))
                                            <button rel="edit" id="{{$emergencyContact->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            @endif
                                            @if($loggedUser->hasAccess(\Request::segment(1).'.emergency-contacts.delete'))
                                            <button rel="delete" id="{{$emergencyContact->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No emergency contacts listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Modal -->

        <div class="modal fade" id="emergencyContactModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="myModalLabel">Emergency Contact Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('employee_id', $employee->id) !!}
                            {!! Form::hidden('emergency_contact_id', '', ['id' => 'emergency_contact_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'emergencyContactForm']) !!}
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
                                    {!! Form::select('relationship_id', HRis\Eloquent\Relationship::lists('name', 'id'), null, ['class' => 'form-control chosen-select']) !!}
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
@stop

@stop

@section('custom_css')

    {!! Html::style('/css/plugins/chosen/chosen.css') !!}

@stop

@section('custom_js')
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

                    var emergencyContact = jQuery.parseJSON(response);

                    // Set fields

                    $('#emergency_contact_id').val(emergencyContact.id);
                    $('#first_name').val(emergencyContact.first_name);
                    $('#middle_name').val(emergencyContact.middle_name);
                    $('#last_name').val(emergencyContact.last_name);
                    $('#relationship_id').val(emergencyContact.relationship_id);
                    $('#home_phone').val(emergencyContact.home_phone);
                    $('#mobile_phone').val(emergencyContact.mobile_phone);

                    $('.chosen-select').trigger("chosen:updated");

                    $("#emergencyContactForm").attr("value", "PATCH");
                    $('#emergencyContactModal').modal('toggle');
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
                        $('#emergencyContact_' + dataId).remove();

                        if($('.emergencyContactsList').length == 0){
                            $('#emergencyContactsBody').append('<tr><td colspan="5">No emergency contacts listed</td></tr>');
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

            $('#addEmergencyContact').click(function () {

                $('#first_name').val('');
                $('#middle_name').val('');
                $('#last_name').val('');
                $('#relationship_id').val(0);
                $('#home_phone').val('');
                $('#mobile_phone').val('');

                $('.chosen-select').trigger("chosen:updated");

                $("#emergencyContactForm").attr("value", "POST");
                $('#emergencyContactModal').modal('toggle');
            });
        });
    </script>

@stop

@section('action_area')
    @include('pages.profile.partials.avatar')
@stop