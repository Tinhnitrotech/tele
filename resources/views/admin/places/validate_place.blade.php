<script type="text/javascript">
    $(document).ready(function() {

        jQuery.validator.addMethod("check_float", function(value, element) {
            let valid = value;
            var valiFloat = true;
            var keyLength = valid.length;
            if(valid.indexOf('.') != -1) {
                let keyAreaVal = valid.split(".");
                if(keyAreaVal[0].length > 10) {
                    valiFloat = false
                }
                if(keyAreaVal[1].length > 2) {
                    valiFloat = false
                }
            } else {
                if(keyLength > 10) {
                    valiFloat = false
                }
            }
            return valiFloat;

        }, "");

        $(document).on("keyup change", "#longitude", function() {
            $('label#latitude-error').hide()
            $('input#latitude').removeClass('error')
        });

        $(document).on("keyup change", "#latitude", function() {
            $('label#longitude-error').hide()
            $('input#longitude').removeClass('error')
        });

        jQuery.validator.addMethod("check_format_coordinate", function(value) {
                var latRule = /^(-?[1-8]?\d(?:\.\d{1,18})?|90(?:\.0{1,18})?)$/;
                var lonRule = /^(-?(?:1[0-7]|[1-9])?\d(?:\.\d{1,18})?|180(?:\.0{1,18})?)$/;

                var latValue = $('#latitude').val();
                var lonValue = $('#longitude').val();

                var validLat = latRule.test(latValue);
                var validLon = lonRule.test(lonValue);

                // Validate Latitude and Longitude
                if(validLat && validLon) {
                    return true
                }else{
                    return false
                }
        }, "");

         // Validate form
        $("#placeForm").validate({
            rules: {
                name:  {
                    required: true,
                    maxlength: 200
                },
                tel: {
                    required: true,
                    minlength:10,
                    maxlength:11
                },
                postal_code_1: {
                    required: true,
                    digits: true,
                    minlength: 3,
                    maxlength: 3,
                },
                postal_code_2: {
                    required: true,
                    digits: true,
                    minlength: 4,
                    maxlength: 4,
                },
                prefecture_id: {
                    required: true,
                    digits: true,
                    minlength: 1,
                    maxlength: 47,
                },
                address: {
                    required: true,
                },
                postal_code_default_1: {
                    required: true,
                    digits: true,
                    minlength: 3,
                    maxlength: 3,
                },
                postal_code_default_2: {
                    required: true,
                    digits: true,
                    minlength: 4,
                    maxlength: 4,
                },
                prefecture_id_default: {
                    required: true,
                    digits: true,
                    minlength: 1,
                    maxlength: 47,
                },
                address_default: {
                    required: true,
                },
                total_place: {
                    required: true,
                    digits: true,
                },
                latitude: {
                    required: true,
                    check_format_coordinate: true,
                    maxlength: 30,
                },
                longitude: {
                    required: true,
                    check_format_coordinate: true,
                    maxlength: 30,
                },
                altitude: {
                    check_float: true
                }
            },
            messages: {
                name:  {
                    required: '{{ trans('validation_form.validate.name_place.required') }}',
                    maxlength: '{{ trans('validation_form.validate.name_place.max') }}',
                },
                tel: {
                    required: '{{ trans('validation_form.validate.tel.required') }}',
                    minlength: '{{ trans('validation_form.validate.tel.digits_between') }}',
                    maxlength: '{{ trans('validation_form.validate.tel.digits_between') }}',
                },
                postal_code_1: {
                    required: '{{ trans('validation_form.validate.postal_code_1.required') }}',
                    digits: '{{ trans('validation_form.validate.postal_code_1.numeric') }}',
                    minlength: '{{ trans('validation_form.validate.postal_code_1.digits') }}',
                    maxlength: '{{ trans('validation_form.validate.postal_code_1.digits') }}',
                },
                postal_code_2: {
                    required: '{{ trans('validation_form.validate.postal_code_2.required') }}',
                    digits: '{{ trans('validation_form.validate.postal_code_2.numeric') }}',
                    minlength: '{{ trans('validation_form.validate.postal_code_2.digits') }}',
                    maxlength: '{{ trans('validation_form.validate.postal_code_2.digits') }}',
                },
                prefecture_id: {
                    required: '{{ trans('validation_form.validate.prefecture_id.required') }}',
                    digits: '{{ trans('validation_form.validate.prefecture_id.numeric') }}',
                    minlength: '{{ trans('validation_form.validate.prefecture_id.min') }}',
                    maxlength: '{{ trans('validation_form.validate.prefecture_id.max') }}',
                },
                address: {
                    required: '{{ trans('validation_form.validate.address.required') }}',
                },
                postal_code_default_1: {
                    required: '{{ trans('validation_form.validate.postal_code_default_1.required') }}',
                    digits: '{{ trans('validation_form.validate.postal_code_default_1.numeric') }}',
                    minlength: '{{ trans('validation_form.validate.postal_code_default_1.digits') }}',
                    maxlength: '{{ trans('validation_form.validate.postal_code_default_1.digits') }}',
                },
                postal_code_default_2: {
                    required: '{{ trans('validation_form.validate.postal_code_default_2.required') }}',
                    digits: '{{ trans('validation_form.validate.postal_code_default_2.numeric') }}',
                    minlength: '{{ trans('validation_form.validate.postal_code_default_2.digits') }}',
                    maxlength: '{{ trans('validation_form.validate.postal_code_default_2.digits') }}',
                },
                prefecture_id_default: {
                    required: '{{ trans('validation_form.validate.prefecture_id_default.required') }}',
                    digits: '{{ trans('validation_form.validate.prefecture_id_default.numeric') }}',
                    minlength: '{{ trans('validation_form.validate.prefecture_id_default.min') }}',
                    maxlength: '{{ trans('validation_form.validate.prefecture_id_default.max') }}',
                },
                address_default: {
                    required: '{{ trans('validation_form.validate.address_default.required') }}',
                },
                total_place: {
                    required: '{{ trans('validation_form.validate.total_place.required') }}',
                    digits: '{{ trans('validation_form.validate.total_place.numeric') }}',
                    maxlength: '{{ trans('common.maxlength_valid_30') }}',
                },
                latitude: {
                    required: '{{ trans('validation_form.validate.latitude.required') }}',
                    check_format_coordinate: '{{ trans('validation_form.validate.latitude.regex') }}',
                },
                longitude: {
                    required: '{{ trans('validation_form.validate.longitude.required') }}',
                    check_format_coordinate: '{{ trans('validation_form.validate.longitude.regex') }}',
                    maxlength: '{{ trans('common.maxlength_valid_30') }}',
                },
                altitude: {
                    check_float: '{{ trans('validation_form.validate.altitude.numeric') }}',
                }
            }
        });
    });
</script>
