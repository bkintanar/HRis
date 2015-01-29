@extends(\Request::is('*pim/*') ? 'master.adm-master' : 'master.default')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Employee List</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content">
                <div class="">
                    <a id="addEmployee" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Job Title</th>
                                <th>Employment Status</th>
                                <th class="fix-width">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(count($employees))
                                @foreach($employees as $employee)
                                <tr id="employee_{{$employee->id}}">
                                    <td><a href="/pim/employee-list/{{ $employee->employee_id }}/personal-details">{{ $employee->employee_id }}</a></td>
                                    <td>{{ $employee->first_name }}</td>
                                    <td>{{ $employee->last_name }}</td>
                                    <td>{{ isset($employee->jobHistory()->job_title_id) ? $employee->jobHistory()->jobTitle->name : '' }}</td>
                                    <td><span class="label {{ isset($employee->jobHistory()->employment_status_id) ? $employee->jobHistory()->employmentStatus->class : '' }}">{{ isset($employee->jobHistory()->employment_status_id) ? $employee->jobHistory()->employmentStatus->name : '' }}</span></td>
                                    <td>
                                        <button rel="edit" id="{{$employee->id}}" class="btn btn-primary btn-xs btn-warning" title="Edit" type="button"><i class="fa fa-paste"></i></button>
                                        <button rel="delete" id="{{$employee->id}}" class="btn btn-primary btn-xs btn-danger" title="Delete" type="button"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No employees listed</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="myModalLabel">Emergency Contact Details</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', \Request::path()), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('id', $employee->id) !!}
                            {!! Form::hidden('emergency_contact_id', '', ['id' => 'emergency_contact_id']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'emergencyContactForm']) !!}
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
                                        {!! Form::select('relationship_id', HRis\Relationship::lists('name', 'id'), null, ['class' => 'form-control chosen-select']) !!}
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
<script>
        $(document).ready(function () {

            $('#addEmployee').click(function () {

                $('#first_name').val('');
                $('#middle_name').val('');
                $('#last_name').val('');
                $('#relationship_id').val(0);
                $('#home_phone').val('');
                $('#mobile_phone').val('');

                $('.chosen-select').trigger("chosen:updated");

                $("#emergencyContactForm").attr("value", "POST");
                $('#employeeModal').modal('toggle');
            });
        });
    </script>
@stop