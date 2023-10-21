<div class="sidebar">
    <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item mt-2">
                <a href="{{route("admin.ticketboard")}}" class="nav-link nav-main-tab tabLink active font-weight-bold">
                  <i class="nav-icon fa fa-th-large fa-lg"></i>
                  <p>Ticket Board</p>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{route("admin.tickethistory")}}" class="nav-link nav-main-tab tabLink">
                  <i class="nav-icon fas fa-history fa-lg"></i>
                  <p>Ticket History</p>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a class="nav-link nav-main-tab">
                  <i class="nav-icon fas fa-sliders-h fa-lg"></i>
                  <p>Setup</p>
                  <i class="right fas fa-angle-left"></i>
                </a>

                <ul class="nav nav-treeview dropdownTab">
                    <li class="nav-item">
                      <a href="{{route("admin.board")}}" class="nav-link nav-tab tabLink">
                        <i class="nav-icon fas fa-building fa-lg"></i>
                        <p>Board</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="{{route("admin.branch")}}" class="nav-link nav-tab tabLink">
                        <i class="nav-icon fas fa-building fa-lg"></i>
                        <p>Branch</p>
                      </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route("admin.department")}}" class="nav-link nav-tab tabLink">
                          <i class="nav-icon fas fa-building fa-lg"></i>
                          <p>Department</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route("admin.subject")}}" class="nav-link nav-tab tabLink">
                          <i class="nav-icon fas fa-file-alt fa-lg"></i>
                          <p>Subject</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-2">
                <a class="nav-link nav-main-tab">
                  <i class="nav-icon fas fa fa-users fa-lg"></i>
                  <p>Users</p>
                  <i class="right fas fa-angle-left"></i>
                </a>

                <ul class="nav nav-treeview dropdownTab">
                    <li class="nav-item">
                        <a href="{{route("admin.admin")}}" class="nav-link nav-tab tabLink">
                          <i class="nav-icon fas fa-user-shield fa-lg"></i>
                          <p>Admin</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route("admin.employee")}}" class="nav-link nav-tab tabLink">
                          <i class="nav-icon fas fa-user-tie fa-lg"></i>
                          <p>Employee</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route("admin.member")}}" class="nav-link nav-tab tabLink">
                          <i class="nav-icon fas fa-user fa-lg"></i>
                          <p>Member</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-2">
                <a href="{{route("admin.account")}}" class="nav-link nav-main-tab tabLink">
                  <i class="nav-icon fas fa-user-cog fa-lg"></i>
                  <p>Manage Account</p>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a href="{{route("admin.report")}}" class="nav-link nav-main-tab tabLink">
                  <i class="nav-icon fas fa-file-alt fa-lg"></i>
                  <p>Reports</p>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a href="{{route("admin.setting")}}" class="nav-link nav-main-tab tabLink">
                  <i class="nav-icon fas fa-cogs fa-lg"></i>
                  <p>Settings</p>
                </a>
            </li>
        </ul>
    </nav>
</div>