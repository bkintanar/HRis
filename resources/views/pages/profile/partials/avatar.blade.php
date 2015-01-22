<div class="col-sm-6">
    <div class="profile-img">

        @if(isset($employee->avatar) != '')
        <img id="profile-image" alt="avatar" src="/img/profile/{{ $employee->avatar }}"/>
        @else
        <img id="profile-image" alt="avatar" src="/img/profile/default/{{$employee->job_title_id}}{{$employee->gender}}.png "/>
        @endif
        <div class="profile-details">

        <h2>{{ $employee->first_name }} {{ $employee->last_name }}</h2>
        <h3>{{ ($employee->job_title_id != 0) ? $employee->jobTitle->name : '' }}</h3>

        @if(\Request::is('*personal-details/edit'))
        <button id="addAvatar" href="javascript:void(0);" type="button" class="btn btn-primary btn-xs">Edit Avatar</button>
        @endif
       </div>
    </div>
</div>