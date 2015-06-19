@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">

        {!! HRis\TablePresenter::display($logged_user, $table) !!}

        <!-- Modal -->
        <div class="modal fade" id="job_title_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Job Title Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('job_title_id', '', ['id' => 'job_title_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'job_title_form']) !!}

                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('description', 'Description', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('description', null, ['class' => 'form-control']) !!}
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

@section('custom_js')

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            function editRecord(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/get-job-title',
                    data: { id: dataId }
                }).done(function( response ) {

                    var job_title = jQuery.parseJSON(response);

                    // Set fields

                    $('#job_title_id').val(job_title.id);
                    $('#name').val(job_title.name);
                    $('#description').val(job_title.description);

                    $("#job_title_form").attr("value", "PATCH");
                    $('#job_title_modal').modal('toggle');
                });
            }

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/delete-job-title',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#job_title_' + dataId).remove();

                        if($('.job_titles_list').length == 0){
                            $('#job_titles_body').append('<tr><td colspan="4">No job titles listed</td></tr>');
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

            $('#add_job_title').click(function () {

                $('#name').val('');
                $('#description').val('');

                $("#job_title_form").attr("value", "POST");
                $('#job_title_modal').modal('toggle');
            });
        });
    </script>

@stop
