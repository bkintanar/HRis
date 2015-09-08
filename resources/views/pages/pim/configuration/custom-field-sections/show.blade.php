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
                        {!! Form::hidden('custom_field_id', '', ['id' => 'custom_field_id']) !!}

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
                        <div class="form-group options" style="display: none;">
                            {!! Form::label('custom_field_options', 'Options', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('custom_field_options', null, ['class' => 'form-control', 'data-role' => 'tagsinput', 'id' => 'custom_field_options']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('required', 'Required', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-sm-9">
                                <label class="checkbox-inline i-checks">
                                {!! Form::checkbox('required', 1, null) !!}
                                </label>
                            </div>
                        </div>


                        <div class="col-md-9">
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
                    url: '/ajax/get-custom-field',
                    data: {id: dataId}
                }).done(function (response) {

                    var data = jQuery.parseJSON(response);

                    var custom_field = data.custom_field;

                    // Set fields

                    $('#custom_field_id').val(custom_field.id);
                    $('#field_name').val(custom_field.name);
                    $('#custom_field_type_id').val(custom_field.custom_field_type_id);

                    if (custom_field.type.has_options) {
                        $.each(data.options, function(index, value) {
                            $('#custom_field_options').tagsinput('add', value);
                        });

                        $('.options').css("display", '');
                    }
                    else {
                        $('.options').css("display", 'none');
                    }

                    $('.chosen-select').trigger("chosen:updated");

                    $("#custom_field_form").attr("value", "PATCH");
                    $('#custom_field_modal').modal('toggle');
                });
            }

            function deleteRecord(dataId) {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/delete-custom-field',
                    data: {id: dataId, _token: $('input[name=_token]').val()}
                }).done(function (response) {

                    if (response == 'success') {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#custom_field_' + dataId).remove();

                        if ($('.custom_fields_list').length == 0) {
                            $('#custom_fields_body').append('<tr><td colspan="3">No custom fields listed</td></tr>');
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
                $('#field_name').val('');
                $('#custom_field_options').tagsinput('removeAll');

                $("#custom_field_form").attr("value", "POST");
                $('.i-checks').iCheck('uncheck');
                $(".chosen-select").val('').attr("data-placeholder", "--- Select ---").trigger("chosen:updated");
                $('#custom_field_modal').modal('toggle');

            });
        });
    </script>

@stop
