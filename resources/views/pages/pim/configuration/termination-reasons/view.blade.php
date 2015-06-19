@extends(Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">

        {!! HRis\TablePresenter::display($logged_user, $table) !!}

        <!-- Modal -->

        <div class="modal fade" id="termination_reason_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Termination Reasons Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => '/pim/configuration/termination-reasons', 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('termination_reason_id', '', ['id' => 'termination_reason_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'termination_reason_form']) !!}

                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
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

                    var termination_reason = jQuery.parseJSON(response);

                    // Set fields

                    $('#termination_reason_id').val(termination_reason.id);
                    $('#name').val(termination_reason.name);

                    $("#termination_reason_form").attr("value", "PATCH");
                    $('#termination_reason_modal').modal('toggle');
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
                        $('#termination_reason_' + dataId).remove();

                        if($('.termination_reasons_list').length == 0){
                            $('#termination_reasons_body').append('<tr><td colspan="3">No termination reasons listed</td></tr>');
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

            $('#add_termination_reason').click(function () {
                $('#name').val('');

                $("#termination_reason_form").attr("value", "POST");
                $('#termination_reason_modal').modal('toggle');
            });
        });
    </script>

@stop
