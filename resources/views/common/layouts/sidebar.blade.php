<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li>
                    <a href="{{route('admin.adminDashboard')}}" class="nav-link">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span>{{trans('admin_top.title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.adminMaterialList')}}" class="nav-link">
                        <i class="mdi mdi-material-design"></i>
                        <span>{{trans('material.title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.adminPlaceList')}}" class="nav-link">
                        <i class="mdi mdi-fireplace"></i>
                        <span>{{trans('place.title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.importCSVView') }}" class="nav-link">
                        <i class="mdi mdi-note-text"></i>
                        <span>{{ trans('qrcode.qrcode_title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.evacuationManagement') }}" class="nav-link">
                        <i class="mdi mdi-file-document-box"></i>
                        <span>{{ trans('evacuation_management.list_title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.ShortageSupplyList')}}" class="nav-link">
                        <i class="ion ion-md-today"></i>
                        <span>{{trans('shortage-supplies.title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.staffManagement') }}" class="nav-link">
                        <i class="mdi mdi-account"></i>
                        <span>{{ trans('staff_management.list_title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.adminManagement') }}" class="nav-link">
                        <i class="mdi mdi-account-key"></i>
                        <span>{{ trans('admin_management.list_title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.statistics')}}" class="nav-link">
                        <i class="mdi mdi-chart-line"></i>
                        <span>{{trans('statistics.title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.settingSystem')}}" class="nav-link">
                        <i class="mdi mdi-settings"></i>
                        <span>{{trans('setting_system.title') }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
