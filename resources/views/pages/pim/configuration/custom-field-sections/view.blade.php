@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">

        {!! TablePresenter::display($logged_user, $table) !!}

        <!-- Modal -->

        <div class="modal fade" id="custom_field_section_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Custom Field Section Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('custom_field_section_id', '', ['id' => 'custom_field_section_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'custom_field_section_form']) !!}

                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('screen_id', 'Screen', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::select('screen_id', Navlink::whereParentId(-1)->lists('name', 'id'), null, ['placeholder' => '--- Select ---', 'class' => 'form-control chosen-select']) !!}
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

@section('custom_js')

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            function editRecord(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/get-termination-reason',
                    data: { id: dataId }
                }).done(function( response ) {

                    var custom_field_section = jQuery.parseJSON(response);

                    // Set fields

                    $('#custom_field_section_id').val(custom_field_section.id);
                    $('#name').val(custom_field_section.name);

                    $("#custom_field_section_form").attr("value", "PATCH");
                    $('#custom_field_section_modal').modal('toggle');
                });
            }

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/delete-termination-reason',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#custom_field_section_' + dataId).remove();

                        if($('.custom_field_sections_list').length == 0){
                            $('#custom_field_sections_body').append('<tr><td colspan="3">No termination reasons listed</td></tr>');
                        }
                    }
                    else
                    {
                        // failed
                    }
                });
            }

            // Chosen
            $('.chosen-select').chosen({width:'100%'});

            $('.btn-xs').click(function(){

                var action = $(this).attr('rel');

                switch (action) {
                    case 'edit'   : editRecord($(this).attr('id'));
                        break;
                    case 'delete' : deleteRecord($(this).attr('id'));
                        break;
                }
            });

            $('#add_custom_field_section').click(function () {
                $('#name').val('');
                $("#custom_field_section_form").attr("value", "POST");
                $('#custom_field_section_modal').modal('toggle');
            });
        });
    </script>

@stop
