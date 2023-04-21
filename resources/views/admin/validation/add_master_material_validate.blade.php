<script type="text/javascript">
    $(document).ready(function () {
        $('#add-master-material-form').validate({
            errorClass: 'error is-invalid',
            rules: {
                name: {
                    required: true,
                    maxlength: 100,
                },
                unit: {
                    required: false,
                    maxlength: 100,
                },

            },
            messages: {
                name: {
                    required: '{{ trans('material.validate.name.required') }}',
                    maxlength: '{{ trans('material.validate.name.max') }}'
                },
                unit: {
                    maxlength: '{{ trans('material.validate.unit.max') }}'
                }
            }
        });
    });
</script>
