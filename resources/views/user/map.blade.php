<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{{ getTypeName().(App::getLocale() == config('constant.language_ja') ? '' : ' ').trans('guest.title_page_map'). " - ".getSystemName()}}</title>
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
<body class="pb-0">
<div class="" style="overflow: hidden;width: 100%;min-height: 100vh">
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block text-center">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-warning alert-block text-center">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div id="map" style="width: 100%;height: 100vh;"></div>
                <div class="current_location" onclick="getLocation();"><i class="mdi mdi-near-me"></i></div>
            </div>
            <input hidden value="{{ $placesResult }}" id="placeValues">
        </div>
    </div>
</div>
<script>
    var place_name = "{{ trans('common.place_name') }}";
    var place_address = "{{ trans('common.place_address') }}";
    var place_capacity = "{{ trans('common.place_capacity') }}";
    var place_people = "{{ trans('common.place_people') }}";
    var place_percent = "{{ trans('common.place_percent') }}";
    var setting_scale = "{{ getScaleMap() }}";
    var getLatitudeDefault = "{{ getLatitudeDefault() }}";
    var getLongitudeDefault = "{{ getLongitudeDefault() }}";
    var altitude = "{{ trans('place.altitude') }}";
</script>
<script src="{{ asset('js/user/map.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&region=en&language=en&callback=initMap" type="text/javascript"></script>
</body>
</html>

