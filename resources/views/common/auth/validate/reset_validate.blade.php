<script type="text/javascript">
    $(document).ready(function() {
        $('#telenet-reset-form').validate({
            errorClass: 'error is-invalid',
            rules: {
                password: {
                    required: true,
                    maxlength: 200,
                },
                password_confirm: {
                    required: true,
                    maxlength: 200,
                },
            },
            messages: {
                password: {
                    required: '{{ trans('common.pass_required_vaild') }}',
                    maxlength: '{{ trans('common.pass_maxlength_valid') }}'
                },
                password_confirm: {
                    required: '{{ trans('common.pass_required_vaild') }}',
                    maxlength: '{{ trans('common.pass_maxlength_valid') }}'
                },
            }
        });
    });
</script>
