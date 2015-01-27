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
                    @if($loggedUser->hasAccess('admin.job.titles.create'))
                    <div class="">
                        <a id="addJobTitle" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
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

                            <tbody id="jobTitlesBody">
                                @if(count($jobTitles))
                                    @foreach($jobTitles as $jobTitle)
                                    <tr class="jobTitlesList" id="jobTitle_{{$jobTitle->id}}">
                                        <td>{{ $jobTitle->id }}</td>
                                        <td>{{ $jobTitle->name }}</td>
                                        <td>{{ $jobTitle->description }}</td>
                                        <td>
                                            @if($loggedUser->hasAccess('admin.job.titles.update'))
                                            <button rel="edit" id="{{$jobTitle->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            @endif
                                            @if($loggedUser->hasAccess('admin.job.titles.delete'))
                                            <button rel="delete" id="{{$jobTitle->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
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
        <div class="modal fade" id="jobTitleModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="myModalLabel">Job Title Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => \Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('job_title_id', '', ['id' => 'job_title_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'jobTitleForm']) !!}
                            <div class="form-group">
                                <div class="row">
                                    {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    {!! Form::label('description', 'Description', ['class' => 'col-md-3 control-label']) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
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

                    $("#jobTitleForm").attr("value", "PATCH");
                    $('#jobTitleModal').modal('toggle');
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
                        $('#jobTitle_' + dataId).remove();

                        if($('.jobTitlesList').length == 0){
                            $('#jobTitlesBody').append('<tr><td colspan="4">No job titles listed</td></tr>');
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

            $('#addJobTitle').click(function () {

                $('#name').val('');
                $('#description').val('');

                $("#jobTitleForm").attr("value", "POST");
                $('#jobTitleModal').modal('toggle');
            });
        });
    </script>

@stop