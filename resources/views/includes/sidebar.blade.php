
<!-- Left Sidenav -->
        <div class="left-sidenav">
            <ul class="metismenu left-sidenav-menu">

                @if(Auth::user()->email == 'admin@gmail.com' || in_array("Services",explode(",",Auth::user()->permissions)))
                <li>
                    <a href="javascript: void(0);"><i class="ti-bar-chart"></i><span>Services</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level in mm-show" aria-expanded="false">
                        <li class="nav-item"><a class="nav-link" href="{{url('/admin/services')}}"><i class="ti-control-record"></i>Service Lists</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('/admin/banks')}}"><i class="ti-control-record"></i>Banks</a></li>

                    </ul>
                </li>
                @endif

                @if(Auth::user()->email == 'admin@gmail.com' || in_array("Staffs",explode(",",Auth::user()->permissions)))
                <li>
                    <a href="javascript: void(0);"><i class="ti-user"></i><span>Staffs</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level in mm-show" aria-expanded="false">
                        <li class="nav-item"><a class="nav-link" href="{{url('/admin/staffs')}}"><i class="ti-control-record"></i>Staff Lists</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('/admin/locations')}}"><i class="ti-control-record"></i>Locations</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('/admin/designations')}}"><i class="ti-control-record"></i>Designations</a></li>

                    </ul>
                </li>
                @endif

                @if(Auth::user()->email == 'admin@gmail.com' || in_array("Users",explode(",",Auth::user()->permissions)))
                <li>
                    <a href="javascript: void(0);"><i class="dripicons-user-group"></i><span>Users</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level in mm-show" aria-expanded="false">
                        <li class="nav-item"><a class="nav-link" href="{{url('/admin/users')}}"><i class="ti-control-record"></i>User Lists</a></li>

                    </ul>
                </li>
                @endif

                @if(Auth::user()->email == 'admin@gmail.com' || in_array("Clients",explode(",",Auth::user()->permissions)))
                <li>
                    <a href="javascript: void(0);"><i class=" dripicons-user-id"></i><span>Clients</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level in mm-show" aria-expanded="false">
                        <li class="nav-item"><a class="nav-link" href="{{url('/admin/enquiries')}}"><i class="ti-control-record"></i>Clients Enquiries</a></li>

                    </ul>
                </li>
                @endif

                @if(Auth::user()->email == 'admin@gmail.com' || in_array("Corporate",explode(",",Auth::user()->permissions)))
                <li>
                    <a href="javascript: void(0);"><i class=" dripicons-user-id"></i><span>Corporates</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level in mm-show" aria-expanded="false">
                        <li class="nav-item"><a class="nav-link" href="{{url('/admin/corporates')}}"><i class="ti-control-record"></i>Corporate Management</a></li>

                    </ul>
                </li>
                @endif

            </ul>
        </div>
        <!-- end left-sidenav-->
