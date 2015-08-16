@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">

        {!! TablePresenter::display($logged_user, $table) !!}

                <!-- Modal -->

        <div class="modal fade" id="custom_field_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Custom Field Section Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('custom_field_section_id', $custom_field_section->id, ['id' => 'custom_field_section_id']) !!}
                        {!! Form::hidden('_method', 'POST', ['id' => 'custom_field_form']) !!}

                        <div class="form-group">
                            {!! Form::label('field_name', 'Field Name', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('field_name', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('custom_field_type_id', 'Type', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::select('custom_field_type_id', HRis\Eloquent\CustomFieldType::lists('name', 'id'), null, ['class' => 'form-control chosen-select']) !!}
                            </div>
                        </div>
                        <div class="options" style="display: none;">
                            <div class="form-group">
                                {!! Form::label(' ', 'Options', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::text('field_name', null, ['class' => 'form-control']) !!}
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-white"> Add</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-3 control-label"></div>
                                <div class="col-md-9">
                                    <ul class="tag-list" style="padding: 0;">
                                        <li>
                                            <a href="#0"><i class="fa fa-times"></i> Family</a>
                                            <input type="hidden" name="custom_field_option_1" value="Family">
                                        </li>
                                        <li>
                                            <a href="#0"><i class="fa fa-times"></i> Work</a>
                                            <input type="hidden" name="custom_field_option_2" value="Work">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('required', 'Required', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::checkbox('required', 1, null, ['class' => 'form-control i-checks']) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-white btn-xs" data-dismiss="modal" type="button">Close</button>
                            {!! Form::submit('Save changes', ['class' => 'btn btn-primary btn-xs']) !!}
                        </div>
                        {!! Form::close() !!}<!--// form-->
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
@stop

@stop

@section('custom_js')

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            function editRecord(dataId) {
                $.ajax({
                    type: "GET",
                    url: '/ajax/get-termination-reason',
                    data: {id: dataId}
                }).done(function (response) {

                    var custom_field = jQuery.parseJSON(response);

                    // Set fields

                    $('#custom_field_id').val(custom_field.id);
                    $('#name').val(custom_field.name);

                    $("#custom_field_form").attr("value", "PATCH");
                    $('#custom_field_modal').modal('toggle');
                });
            }

            function deleteRecord(dataId) {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/delete-termination-reason',
                    data: {id: dataId, _token: $('input[name=_token]').val()}
                }).done(function (response) {

                    if (response == 'success') {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#custom_field_' + dataId).remove();

                        if ($('.custom_fields_list').length == 0) {
                            $('#custom_fields_body').append('<tr><td colspan="3">No termination reasons listed</td></tr>');
                        }
                    }
                    else {
                        // failed
                    }
                });
            }

            // Chosen
            $('.chosen-select').chosen({width: '100%'}).change(function () {
                var idx = $('.chosen-select').val();

                if (idx == 2 || idx == 7 || idx == 8) {
                    $('.options').css("display", '');
                }
                else {
                    $('.options').css("display", 'none');
                }
            });

            $('.btn-xs').click(function () {

                var action = $(this).attr('rel');

                switch (action) {
                    case 'edit'   :
                        editRecord($(this).attr('id'));
                        break;
                    case 'delete' :
                        deleteRecord($(this).attr('id'));
                        break;
                }
            });

            $('#add_custom_field').click(function () {
                $('#name').val('');

                $("#custom_field_form").attr("value", "POST");
                $('#custom_field_modal').modal('toggle');
            });
        });
    </script>

@stop
