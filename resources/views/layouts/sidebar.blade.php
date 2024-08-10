        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <script>
            let sidebarToggle = parseInt(localStorage.getItem('navbarToggle') ?? 0);
            // Check the navbarState and add/remove the "toggle" class accordingly
            if (sidebarToggle == 1) {
                $("#accordionSidebar").addClass("toggled");
            } else if (sidebarToggle == 0) {
                $("#accordionSidebar").removeClass("toggled");
            }
        </script>

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <img src="{!! asset('img/') !!}/{{ \App\Helpers\Helper::appSetting('app_logo') ?? 'logo.png' }}" class="sidebar-brand-icon sidebar-logo" alt="">
                <div class="sidebar-brand-text">{{ \App\Helpers\Helper::appSetting('app_name') }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                System
            </div>

            
            <!-- Nav Item - Users Collapse Menu -->
            @if (\App\Helpers\Helper::userAccessOr('view users', 'view roles'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
                    aria-expanded="true" aria-controls="collapseUsers">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span>
                </a>
                <div id="collapseUsers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Roles and Permission:</h6>
                        @can('view users')
                        <a class="collapse-item" href="{{ route('users') }}">Users</a>
                        @endcan
                        @can('view roles')
                        <a class="collapse-item" href="{{ route('roles') }}">Roles</a>
                        @endcan
                        @can('view permissions')
                        <a class="collapse-item" href="{{ route('permissions') }}">Permission</a>
                        @endcan
                    </div>
                </div>
            </li>
            @endif


            <!-- Nav Item - Hospitals Collapse Menu -->
            @if (\App\Helpers\Helper::userAccessOr('view hospitals', 'view pm-jay-resources'))
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHospitals"
                    aria-expanded="true" aria-controls="collapseHospitals">
                    <i class="fas fa-fw fa-hospital"></i>
                    <span>Hospitals</span>
                </a>
                <div id="collapseHospitals" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Hospitals:</h6>
                        @can('view hospitals')
                        <a class="collapse-item" href="{{ route('hospitals') }}">Hospitals</a>
                        @endcan
                        @can('view pm-jay-resources')
                        <a class="collapse-item" href="{{ route('pm-jay-resources') }}">PMJAY resources</a>
                        @endcan
                        @can('view specialities')
                        <a class="collapse-item" href="{{ route('specialities') }}">Specialities</a>
                        @endcan
                        @can('view doctors')
                        <a class="collapse-item" href="{{ route('doctors') }}">Doctors</a>
                        @endcan
                    </div>
                </div>
            </li>
            @endif


            @if (\App\Helpers\Helper::userAccessOr('view enquiries'))
            <!-- Nav Item - Enquiries -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('enquiries') }}">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span>Enquiry</span>
                </a>
            </li>
            @endif


            @if (\App\Helpers\Helper::userAccessOr('view sliders'))
            <!-- Nav Item - sliders -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sliders') }}">
                    <i class="fas fa-fw fa-sliders-h"></i>
                    <span>Sliders</span>
                </a>
            </li>
            @endif    
            
            
            @if (\App\Helpers\Helper::userAccessOr('view front-setting'))
            <!-- Nav Item - front-setting -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('front-setting') }}">
                    <i class="fas fa-fw fa-sliders-h"></i>
                    <span>Front Setting</span>
                </a>
            </li>
            @endif    

          
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->