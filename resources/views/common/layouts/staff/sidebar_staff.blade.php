<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li>
                    <a href="{{routeByPlaceId('staff.staffDashboard')}}" class="nav-link">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span>{{trans('staff_dashboard.page_title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{routeByPlaceId('staff.suppliesIndex')}}" class="nav-link">
                        <i class="mdi mdi-fireplace"></i>
                        <span>{{trans('staff_supplies_index.page_title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ routeByPlaceId('staff.familyIndex') }}" class="nav-link">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span>{{trans('staff_refuge_index.page_title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{routeByPlaceId('staff.addFamily')}}" class="nav-link">
                        <i class="mdi mdi-material-design"></i>
                        <span>{{trans('staff_add_family.page_title') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{routeByPlaceId('staff.familyDetail')}}" class="nav-link">
                        <i class="mdi mdi-material-design"></i>
                        <span>{{trans('staff_refuge_detail.page_title') }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
