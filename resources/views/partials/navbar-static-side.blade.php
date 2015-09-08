        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">

                        <div class="dropdown profile-element"> <span>
                            @if(!is_null ($logged_user->employee->avatar))
                            <img alt="image" id="profile-image-nav" class="img-circle" src="/img/profile/{{$logged_user->employee->avatar}}">
                            @else
                            <img alt="image" id="profile-image-nav" class="img-circle" src="/img/profile/default/{{$logged_user->employee->jobHistory()->job_title_id }}{{$logged_user->employee->gender}}.png">
                            @endif
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ $logged_user->employee->first_name }} {{ $logged_user->employee->last_name }}</strong>
                                </span> <span class="text-muted text-xs block">
                                    {{ $logged_user->employee->jobHistory() ? $logged_user->employee->jobHistory()->jobTitle->name : 'N/A' }}
                                <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="/profile">Profile</a></li>
                                <li><a href="contacts.html">Contacts</a></li>
                                <li><a href="mailbox.html">Mailbox</a></li>
                                <li class="divider"></li>
                                <li><a href="/auth/logout">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            HRis
                        </div>

                    </li>

                    {!! Sidebar::make() !!}

                </ul>

            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        @include('partials.navbar-static-top')
        </div>
