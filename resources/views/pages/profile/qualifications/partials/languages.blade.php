<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Languages</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                <div class="">
                    <a id="add_language" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Relationship</th>
                                <th>Home Telephone</th>
                                <th>Mobile</th>
                                <th class="fix-width">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($qualifications as $qualification)
                            <tr id="qualification_{{$qualification->id}}">
                                <td>{{ $qualification->first_name }} {{$qualification->middle_name}} {{ $qualification->last_name }}</td>
                                <td>{{ HRis\Eloquent\Relationship::whereId($qualification->relationship_id)->pluck('name') }}</td>
                                <td>{{ $qualification->home_phone }}</td>
                                <td>{{ $qualification->mobile_phone }}</td>
                                <td>
                                    <button rel="edit" id="{{$qualification->id}}"
                                            class="btn btn-primary btn-xs btn-warning" name="edit" title="Edit"
                                            type="button"><i class="fa fa-edit"></i></button>
                                    <button rel="delete" id="{{$qualification->id}}"
                                            class="btn btn-primary btn-xs btn-danger" name="delete" title="Delete"
                                            type="button"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- Modal -->

    <div class="modal fade" id="qualification_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>

                    <h4 class="modal-title" id="my_model_label">Language Details</h4>
                </div>

                <div class="modal-body">
                    <!--Add form-->
                    {!! Form::open(['method' => 'POST', 'url' => '/profile/emergency-contacts', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('id', $employee->id) !!}
                        {!! Form::hidden('emergency_contact_id', '', ['id' => 'emergency_contact_id']) !!}
                        {!! Form::hidden('_method', 'POST', ['id' => 'qualificationForm']) !!}
                        <div class="form-group">
                            <div class="row">
                                {!! Form::label('first_name', 'First Name', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                {!! Form::label('middle_name', 'Middle Name', ['class' => 'col-md-3 control-label']) !!}

                                <div class="col-md-9">
                                    {!! Form::text('middle_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                {!! Form::label('last_name', 'Last Name', ['class' => 'col-md-3 control-label']) !!}

                                <div class="col-md-9">
                                    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                {!! Form::label('relationship_id', 'Relationship', ['class' => 'col-md-3 control-label']) !!}

                                <div class="col-md-9">
                                    {!! Form::select('relationship_id', HRis\Eloquent\Relationship::lists('name', 'id'), null, ['data-placeholder' => '--- Select ---', 'class' => 'form-control chosen-select']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                {!! Form::label('home_phone', 'Home Telephone', ['class' => 'col-md-3 control-label']) !!}

                                <div class="col-md-9">
                                    {!! Form::text('home_phone', null, ['class' => 'form-control', 'data-mask' => '099 999 9999']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                {!! Form::label('mobile_phone', 'Mobile', ['class' => 'col-md-3 control-label']) !!}

                                <div class="col-md-9">
                                    {!! Form::text('mobile_phone', null, ['class' => 'form-control', 'data-mask' => '0999 999 9999']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-white" data-dismiss="modal" type="button">Close</button>
                            {!! Form::submit('Save changes', ['class' => 'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}<!--// form-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
