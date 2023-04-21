<!DOCTYPE html>
<html lang="en">
@include('common.layouts.head')
<body>
    <header id="topnav">
        <!-- Topbar Start -->
        @include('common.layouts.staff.header')
        <!-- end Topbar -->
    </header>

    <!-- Begin page -->
    <div class="wrapper">
        @yield('content')
    </div>
    <!-- END wrapper -->

    <!-- Footer Start -->
    @include('common.layouts.footer', ['classFooter' => 'left-0'])
    <!-- end Footer -->

    <!-- Loading -->
    <div class="overlay"><div class="loader"></div></div>
    @include('common.layouts.script')
    @stack('scripts')
</body>
</html>
