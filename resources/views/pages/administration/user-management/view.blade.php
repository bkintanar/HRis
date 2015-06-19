@extends('master.adm-master')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>HRis Users</h5>
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
                                <th>Username</th>
                                <th>Employee Name</th>
                                <th>User Role</th>
                                <th>User Active</th>
                                <th class="fix-width">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(count($users))
                                @foreach($users as $user)
                                <tr id="user_{{$user->id}}">
                                    <td><a href="/admin/user-management/{{ $user->id }}">{{ $user->id }}</a></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->employee->first_name }} {{ $user->employee->last_name }}</td>
                                    <td>{{ $user->group()->name }}</td>
                                    <td>{{ $user->activated ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <button rel="edit" id="{{$user->id}}" class="btn btn-primary btn-xs btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit" type="button"><i class="fa fa-edit"></i></button>
                                        <button rel="delete" id="{{$user->id}}" class="btn btn-primary btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="button"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No users listed</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- Modal -->
</div>
@stop

@section('custom_js')
@stop