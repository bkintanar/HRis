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
            <h4><span id="addAvatar" class="label label-primary">Edit Avatar</span></h4>
        @else
            <h4><span class="label {{ isset($employee->employmentStatus) ? $employee->employmentStatus->class : '' }}">{{ isset($employee->employmentStatus) ? $employee->employmentStatus->name : '' }}</span></h4>
        @endif
       </div>
    </div>
</div>