@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Job Titles</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    @if($logged_user->hasAccess('admin.job.titles.create'))
                    <div class="">
                        <a id="add_job_title" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Job Title</th>
                                    <th>Job Description</th>
                                    <th class="fix-width">Action</th>
                                </tr>
                            </thead>

                            <tbody id="job_titles_body">
                                @if(count($jobTitles))
                                    @foreach($jobTitles as $job_title)
                                    <tr class="job_titles_list" id="job_title_{{$job_title->id}}">
                                        <td>{{ $job_title->id }}</td>
                                        <td>{{ $job_title->name }}</td>
                                        <td>{{ $job_title->description }}</td>
                                        <td>
                                            @if($logged_user->hasAccess('admin.job.titles.update'))
                                            <button rel="edit" id="{{$job_title->id}}" class="btn btn-primary btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-edit"></i></button>
                                            @endif
                                            @if($logged_user->hasAccess('admin.job.titles.delete'))
                                            <button rel="delete" id="{{$job_title->id}}" class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="button"><i class="fa fa-times"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No job titles listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Modal -->
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
