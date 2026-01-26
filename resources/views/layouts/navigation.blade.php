<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>

            @if(!request()->routeIs('profile.*'))
                <li class="nav-item">
                    <a href="{{ route('events.index') }}" class="nav-link  @if(request()->routeIs('events.*')) active @endif">
                        <i class="nav-icon fas fa-calendar-alt pl-1 pr-2"></i>
                        <p>
                            {{ __('Manage Events') }}
                        </p>
                    </a>
                </li>

                @if(!auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('redirect') }}" class="nav-link  @if(request()->routeIs('faculties.attendance') || request()->routeIs('students.attendance')) active @endif">
                            <i class="nav-icon fas fa-calendar-alt pl-1 pr-2"></i>
                            <p>
                                {{ __('My Attendance') }}
                            </p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->isAdmin())
                    
                    <li class="nav-item @if(request()->routeIs('students.*')|| request()->routeIs('faculties.*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{ __('Users') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: @if(request()->routeIs('students.*') || request()->routeIs('faculties.*')) block @else none @endif;">
                            <li class="nav-item">
                                <a href="{{ route('students.index') }}" class="nav-link @if(request()->routeIs('students.*')) active @endif">
                                    <i class="nav-icon fas fa-user-graduate"></i>
                                    <p>Manage Students</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('faculties.index') }}" class="nav-link @if(request()->routeIs('faculties.*')) active @endif">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>Manage Faculty</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item @if(request()->routeIs('attendance.report') || request()->routeIs('report.event')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                {{ __('Generate Report') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: @if(request()->routeIs('attendance.report') || request()->routeIs('report.event')) block @else none @endif;">
                            <li class="nav-item">
                                <a href="{{ route('attendance.report') }}" class="nav-link @if(request()->routeIs('attendance.report')) active @endif">
                                    <i class="nav-icon fas fa-user-check"></i>
                                    <p>Event Records</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.event') }}" class="nav-link @if(request()->routeIs('report.event')) active @endif">
                                    <i class="nav-icon far fa-calendar"></i>
                                    <p>Event History</p>
                                </a>
                            </li>
                           
                            <li class="nav-item">
                                 <a href="{{ route('report.student') }}" class="nav-link @if(request()->routeIs('report.student')) active @endif">
                                    <i class="nav-icon far fa-user"></i>
                                    <p>Attendace Report </p>
                                </a>

                            </li>


                            



                        </ul>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <a href="{{ route('profile.show') }}" class="nav-link @if(request()->routeIs('profile.show')) active @endif">
                        <i class="nav-icon far fa-address-card"></i>
                        <p>
                            {{ __('Manage Information') }}
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('profile.password-show') }}" class="nav-link @if(request()->routeIs('profile.password-show')) active @endif">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            {{ __('Manage Password') }}
                        </p>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->