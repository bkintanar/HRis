@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Employment Status</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    @if($logged_user->hasAccess('admin.job.employment-status.create'))
                    <div class="">
                        <a id="addEmploymentStatus" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th class="fix-width">Action</th>
                                </tr>
                            </thead>

                            <tbody id="employmentStatusesBody">
                                @if(count($employmentStatuses))
                                    @foreach($employmentStatuses as $employmentStatus)
                                    <tr class="employmentStatusesList" id="employmentStatus_{{$employmentStatus->id}}">
                                        <td>{{ $employmentStatus->id }}</td>
                                        <td><span class="label {{ $employmentStatus->class }}">{{ $employmentStatus->name }}</span></td>
                                        <td>
                                            @if($logged_user->hasAccess('admin.job.employment-status.update'))
                                            <button rel="edit" id="{{$employmentStatus->id}}" class="btn btn-primary btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            @endif
                                            @if($logged_user->hasAccess('admin.job.employment-status.delete'))
                                            <button rel="delete" id="{{$employmentStatus->id}}" class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No employment status listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Modal -->
        <div class="modal fade" id="employmentStatusModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="myModalLabel">Employment Status Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => \Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('employment_status_id', '', ['id' => 'employment_status_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'employmentStatusForm']) !!}

                            <div class="form-group">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('class', 'Class', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('class', null, ['class' => 'form-control', 'required']) !!}
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
                    url: '/ajax/get-employment-status',
                    data: { id: dataId }
                }).done(function( response ) {

                    var employment_status = jQuery.parseJSON(response);

                    // Set fields

                    $('#employment_status_id').val(employment_status.id);
                    $('#name').val(employment_status.name);
                    $('#class').val(employment_status.class);

                    $("#employmentStatusForm").attr("value", "PATCH");
                    $('#employmentStatusModal').modal('toggle');
                });
            }

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/delete-employment-status',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#employmentStatus_' + dataId).remove();

                        if($('.employmentStatusesList').length == 0){
                            $('#employmentStatusesBody').append('<tr><td colspan="3">No employment status listed</td></tr>');
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

            $('#addEmploymentStatus').click(function () {

                $('#name').val('');
                $('#class').val('');

                $("#employmentStatusForm").attr("value", "POST");
                $('#employmentStatusModal').modal('toggle');
            });
        });
    </script>

@stop