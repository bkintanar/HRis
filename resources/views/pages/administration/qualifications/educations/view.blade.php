@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Education</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    @if($logged_user->hasAccess('admin.qualifications.educations.create'))
                    <div class="">
                        <a id="add_education" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
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

                            <tbody id="educations_body">
                                @if(count($educations))
                                    @foreach($educations as $education)
                                    <tr class="educations_list" id="education_{{$education->id}}">
                                        <td>{{ $education->id }}</td>
                                        <td>{{ $education->name }}</td>
                                        <td>
                                            @if($logged_user->hasAccess('admin.qualifications.educations.update'))
                                            <button rel="edit" id="{{$education->id}}" class="btn btn-primary btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-edit"></i></button>
                                            @endif
                                            @if($logged_user->hasAccess('admin.qualifications.educations.delete'))
                                            <button rel="delete" id="{{$education->id}}" class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="button"><i class="fa fa-times"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No educations listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Modal -->
        <div class="modal fade" id="education_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Education Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('education_id', '', ['id' => 'education_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'education_form']) !!}

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

@section('custom_js')

    {!! Html::script('/js/notification.js') !!}

    <script>
        $(document).ready(function () {

            function editRecord(dataId)
            {
                $.ajax({
                    type: "GET",
                    url: '/ajax/get-education',
                    data: { id: dataId }
                }).done(function( response ) {

                    var employment_status = jQuery.parseJSON(response);

                    // Set fields

                    $('#education_id').val(employment_status.id);
                    $('#name').val(employment_status.name);

                    $("#education_form").attr("value", "PATCH");
                    $('#education_modal').modal('toggle');
                });
            }

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/delete-education',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#education_' + dataId).remove();

                        if($('.educations_list').length == 0){
                            $('#educations_body').append('<tr><td colspan="3">No educations listed</td></tr>');
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

            $('#add_education').click(function () {

                $('#name').val('');

                $("#education_form").attr("value", "POST");
                $('#education_modal').modal('toggle');
            });
        });
    </script>

@stop
