<div class="col-sm-6">
    <div class="profile-img">

        @if(isset($employee->avatar) != '')
        <img id="profile-image" alt="avatar" src="/img/profile/{{ $employee->avatar }}"/>
        @else
        <img id="profile-image" alt="avatar" src="/img/profile/default/{{ $employee->jobHistory()->job_title_id or '0' }}{{ $employee->gender or '0' }}.png"/>
        @endif
        <div class="profile-details">

        <h2>{{ $employee->first_name }} {{ $employee->last_name }}</h2>
        <h3>{{ $employee->jobHistory()->jobTitle->name or '' }}</h3>

        @if(Request::is('*personal-details/edit'))
            <h4><span id="addAvatar" class="label label-primary">Edit Avatar</span></h4>
        @else
            <h4><span class="label {{ $employee->jobHistory()->employmentStatus->class or '' }}">{{ $employee->jobHistory()->employmentStatus->name or '' }}</span></h4>
        @endif
        </div>
    </div>
</div>
