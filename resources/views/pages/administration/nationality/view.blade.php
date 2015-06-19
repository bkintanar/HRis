@extends('master.adm-master')

@section('content')
    @include('partials.notification')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Nationalities</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <div class="">
                        <a id="add_nationality" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th class="fix-width">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($nationalities))
                                    @foreach($nationalities as $nationality)
                                    <tr id="nationality_{{$nationality->id}}">
                                        <td>{{ $nationality->id }}</td>
                                        <td>{{ $nationality->name }}</td>
                                        <td>
                                            <button rel="edit" id="{{$nationality->id}}" class="btn btn-primary btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-edit"></i></button>
                                            <button rel="delete" id="{{$nationality->id}}" class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="button"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No nationalities listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Modal -->

        <div class="modal fade" id="nationality_modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Nationalities Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => Request::path(), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('nationality_id', '', ['id' => 'nationality_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'nationality_form']) !!}
                            <div class="form-group">
                                <div class="row">
                                    {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
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
                    url: '/ajax/get-nationality',
                    data: { id: dataId }
                }).done(function( response ) {

                    var nationality = jQuery.parseJSON(response);

                    // Set fields

                    $('#nationality_id').val(nationality.id);
                    $('#name').val(nationality.name);

                    $("#nationality_form").attr("value", "PATCH");
                    $('#nationality_modal').modal('toggle');
                });
            }

            function deleteRecord(dataId)
            {
                $.ajax({
                    type: "DELETE",
                    url: '/ajax/delete-nationality',
                    data: { id: dataId, _token: $('input[name=_token]').val() }
                }).done(function( response ) {

                    if (response == 'success')
                    {
                        $('#notification-info').show();
                        $("#notification-info").delay(5000).fadeOut();
                        $('#nationality_' + dataId).remove();

                        if($('.nationalities_list').length == 0){
                            $('#nationalities_body').append('<tr><td colspan="3">No termination reasons listed</td></tr>');
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

            $('#add_nationality').click(function () {

                $('#name').val('');

                $("#nationality_form").attr("value", "POST");
                $('#nationality_modal').modal('toggle');
            });
        });
    </script>

@stop
