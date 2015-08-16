@extends('master.adm-master')

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
                    <a id="add_employee" href="javascript:void(0);" class="btn btn-primary btn-xs">Add a new row</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                @foreach($columns as $key => $column)
                                <th>{!! HRis\Services\Pagination::getSortLinks($key, $column, $settings) !!}</th>
                                @endforeach
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
                                    <td>{{ $employee->jobHistory()->jobTitle->name or '' }}</td>
                                    <td>
                                        <span class="label {{ $employee->jobHistory()->employmentStatus->class or '' }}">{{ $employee->jobHistory()->employmentStatus->name or '' }}</span>
                                    </td>
                                    <td>
                                        <a href="/pim/employee-list/{{ $employee->employee_id }}/personal-details"><button rel="edit" id="{{$employee->id}}" class="btn btn-primary btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-edit"></i></button></a>
                                        <button rel="delete" id="{{$employee->id}}" class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" data-toggle="tooltip" data-placement="bottom" title="Delete" type="button"><i class="fa fa-times"></i></button>
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
                {!! HRis\Services\Pagination::setupPagination($employees, $settings) !!}
            </div>
        </div>

    </div>
</div><!-- Modal -->
    <div class="modal fade" id="employee_modal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" type="button">&times;</button>

                        <h4 class="modal-title" id="my_modal_label">Add New Employee</h4>
                    </div>

                    <div class="modal-body">
                        <!--Add form-->
                        {!! Form::open(['method' => 'POST', 'url' => str_replace('/edit', '', Request::path()), 'class' => 'form-horizontal']) !!}
                            {!! Form::hidden('_method', 'POST', ['id' => 'employeeForm']) !!}

                            <div class="form-group">
                                {!! Form::label('first_name', 'Full Name', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-md-4">
                                    {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
                                    <span class="help-block m-b-none">First Name</span>
                                </div>
                                <div class="col-md-2">
                                    {!! Form::text('middle_name', null, ['class' => 'form-control']) !!}
                                    <span class="help-block m-b-none">Middle Name</span>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('last_name', null, ['class' => 'form-control', 'required', 'id' => 'last_name']) !!}
                                    <span class="help-block m-b-none">Last Name</span>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                {!! Form::label('employee_id', 'Employee Id', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-sm-4">
                                    {!! Form::text('employee_id', null, ['class' => 'form-control', 'data-mask' => $employee_id_prefix . '9999', 'required' => 'required']) !!}
                                </div>
                                {!! Form::label('face_id', 'Face Id', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-sm-4">
                                    {!! Form::text('face_id', null, ['class' => 'form-control', 'data-mask' => '999']) !!}
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                {!! Form::label('gender', 'Gender', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-sm-4">
                                    <label class="radio-inline i-checks">
                                        {!! Form::radio('gender', 'M', null) !!} Male
                                    </label>
                                    <label class="radio-inline i-checks">
                                        {!! Form::radio('gender', 'F', null) !!} Female
                                    </label>
                                </div>

                                {!! Form::label('marital_status_id', 'Marital Status', ['class' => 'col-md-2 control-label']) !!}
                                <div class="col-sm-4">
                                    {!! Form::select('marital_status_id', HRis\Eloquent\MaritalStatus::listsWithPlaceholder('name', 'id'), 1, ['class' => 'form-control chosen-select']) !!}
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

@section('custom_css')

    <!-- Data Tables -->
    {!! Html::style('/css/plugins/dataTables/dataTables.bootstrap.css') !!}
    {!! Html::style('/css/plugins/dataTables/dataTables.responsive.css') !!}
@stop

@section('custom_js')

    <script>
        $(document).ready(function () {

            $('#employee_modal').on('shown.bs.modal', function () {
                $('.chosen-select').chosen();
            });


            $('#add_employee').click(function () {

                $('#employee_modal').modal('toggle');

                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green'
                });


            });


        });
    </script>
@stop
