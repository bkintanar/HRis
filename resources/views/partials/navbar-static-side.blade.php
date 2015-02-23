        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">

                        <div class="dropdown profile-element"> <span>
                            @if($loggedUser->employee->avatar != '')
                            <img alt="image" id="profile-image-nav" class="img-circle" src="/img/profile/{{$loggedUser->employee->avatar}}">
                            @else
                            <img alt="image" id="profile-image-nav" class="img-circle" src="/img/profile/default/{{$loggedUser->employee->jobHistory()->job_title_id }}{{$loggedUser->employee->gender}}.png">
                            @endif
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ $loggedUser->employee->first_name }} {{ $loggedUser->employee->last_name }}</strong>
                             </span> <span class="text-muted text-xs block">{{ $loggedUser->employee->jobHistory()->jobTitle->name }} <b class="caret"></b></span> </span> </a>
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

                    {!! HRis\Eloquent\Navlink::generate() !!}

                </ul>

            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        @include('partials.navbar-static-top')
        </div>