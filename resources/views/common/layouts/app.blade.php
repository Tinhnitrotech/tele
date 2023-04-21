<!DOCTYPE html>
<html lang="en">
@include('common.layouts.head')
<body>
<!-- Begin page -->
<div id="wrapper">
    <!-- Topbar Start -->
    @include('common.layouts.header')
    <!-- end Topbar -->

    <!-- Left Sidebar Start -->
    @include('common.layouts.sidebar')
    <!-- Left Sidebar End -->

    <!-- Start Page Content here -->
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                @yield('breadcrumb')
                <!-- end page title -->

                <!-- Content -->
                @yield('content')
                <!-- Content -->
            </div>
            <!-- end container-fluid -->
        </div> <!-- end content -->

        <!-- Footer Start -->
        @include('common.layouts.footer')
        <!-- end Footer -->
    </div>
    <!-- End Page content -->
</div>
<!-- END wrapper -->
<!-- Loading -->
<div class="overlay"><div class="loader"></div></div>
@include('common.layouts.script')
@stack('scripts')
</body>
</html>
