@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')
    @include('partials.notification')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Termination Reasons</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    @if($loggedUser->hasAccess('pim.configuration.termination-reasons.create'))
                    <div class="">
                        <a id="addTerminationReasons" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
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

                            <tbody id="terminationReasonsBody">
                                @if(count($terminationReasons))
                                    @foreach($terminationReasons as $terminationReason)
                                    <tr class="terminationReasonsList" id="termination_reason_{{$terminationReason->id}}">
                                        <td>{{ $terminationReason->id }}</td>
                                        <td>{{ $terminationReason->name }}</td>
                                        <td>
                                            @if($loggedUser->hasAccess('pim.configuration.termination-reasons.update'))
                                            <button rel="edit" id="{{$terminationReason->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                            @endif
                                            @if($loggedUser->hasAccess('pim.configuration.termination-reasons.delete'))
                                            <button rel="delete" id="{{$terminationReason->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No termination reasons listed</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Modal -->

        <div class="modal fade" id="terminationReasonModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="myModalLabel">Termination Reasons Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => '/pim/configuration/termination-reasons', 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('termination_reason_id', '', ['id' => 'termination_reason_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'terminationReasonForm']) !!}

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

                    $("#terminationReasonForm").attr("value", "PATCH");
                    $('#terminationReasonModal').modal('toggle');
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

                        if($('.terminationReasonsList').length == 0){
                            $('#terminationReasonsBody').append('<tr><td colspan="3">No termination reasons listed</td></tr>');
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

            $('#addTerminationReasons').click(function () {

                $('#name').val('');

                $("#terminationReasonForm").attr("value", "POST");
                $('#terminationReasonModal').modal('toggle');
            });
        });
    </script>

@stop