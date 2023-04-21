<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Plugin css -->
    <link href="{{ asset('dist_admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dist_admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('dist_admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('template_admin/js/vendor.js') }}"></script>
    <script src="{{ asset('template_admin/js/vendor/jquery.js') }}"></script>
</head>
<body class="authentication-bg">
<div class="account-pages pt-5 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-10">
                <div class="text-center">
                    <div class="text-error shadow-text">500</div>
                    <h3 class="text-uppercase text-white">Internal Server Error</h3>
                    <p class="text-white mt-4">
                        {{ trans('common.error_page') }}
                    </p>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>
