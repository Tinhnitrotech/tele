<script type="text/javascript">
    $(document).ready(function() {

         // Validate form
        $("#setting-form").validate({
            rules: {
                map_scale:  {
                    required: true,
                    digits: true,
                    minlength:1,
                    maxlength:25
                },
                footer: {
                    required: true,
                    maxlength:200,
                },
                type_name_ja: {
                    required: true,
                    maxlength:200,
                },
                type_name_en: {
                    required: true,
                    maxlength:200,
                },
                system_name_en: {
                    required: true,
                    maxlength:200,
                },
                system_name_ja: {
                    required: true,
                    maxlength:200,
                },
                disclosure_info_ja: {
                    required: true,
                    maxlength:255,
                },
                disclosure_info_en: {
                    required: true,
                    maxlength:255,
                },
                latitude: {
                    required: true,
                    maxlength:30,
                },
                longitude: {
                    required: true,
                    maxlength:30,
                },
                image_logo:  {
                    accept: "image/jpeg, image/jpg, image/png",
                    fileSize: 3145728,
                },
            },
            messages: {
                map_scale:  {
                    required: '{{ trans('setting_system.validate.map_scale.required') }}',
                    digits: '{{ trans('setting_system.validate.map_scale.digits') }}',
                    minlength: '{{ trans('setting_system.validate.map_scale.minlength') }}',
                    maxlength: '{{ trans('setting_system.validate.map_scale.maxlength') }}',
                },
                footer: {
                    required: '{{ trans('setting_system.validate.footer.required') }}',
                    maxlength: '{{ trans('common.maxlength_valid_200') }}',
                },
                type_name_ja: {
                    required: '{{ trans('setting_system.validate.type_name_ja.required') }}',
                    maxlength: '{{ trans('common.maxlength_valid_200') }}',
                },
                type_name_en: {
                    required: '{{ trans('setting_system.validate.type_name_en.required') }}',
                    maxlength: '{{ trans('common.maxlength_valid_200') }}',
                },
                system_name_en: {
                    required: '{{ trans('setting_system.validate.system_name_en.required') }}',
                    maxlength: '{{ trans('common.maxlength_valid_200') }}',
                },
                system_name_ja: {
                    required: '{{ trans('setting_system.validate.system_name_ja.required') }}',
                    maxlength: '{{ trans('common.maxlength_valid_200') }}',
                },
                disclosure_info_ja: {
                    required: '{{ trans('setting_system.validate.disclosure_info_ja.required') }}',
                    maxlength: '{{ trans('common.maxlength_valid_255') }}',
                },
                disclosure_info_en: {
                    required: '{{ trans('setting_system.validate.disclosure_info_en.required') }}',
                    maxlength: '{{ trans('common.maxlength_valid_255') }}',
                },
                latitude: {
                    required: '{{ trans('validation_form.validate.latitude.required') }}',
                    maxlength: '{{ trans('common.maxlength_valid_30') }}',
                },
                longitude: {
                    required: '{{ trans('validation_form.validate.longitude.required') }}',
                    maxlength: '{{ trans('common.maxlength_valid_30') }}',
                },
                image_logo:  {
                    accept: '{{ trans('setting_system.validate.image_logo.mines') }}',
                    fileSize: '{{ trans('setting_system.validate.image_logo.max') }}',
                },
            }
        });
    });
    $.validator.addMethod('fileSize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    });
</script>
