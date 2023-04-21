<script type="text/javascript">
    $(document).ready(function() {
        $('#telenet-login-form').validate({
            errorClass: 'error is-invalid',
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 100,
                },
                password: {
                    required: true,
                    maxlength: 200,
                },
            },
            messages: {
                email: {
                    required: '{{ trans('common.email_required_vaild') }}',
                    email: '{{ trans('common.email_valid') }}',
                    maxlength: '{{ trans('common.email_maxlength_valid') }}'
                },
                password: {
                    required: '{{ trans('common.pass_required_vaild') }}',
                    maxlength: '{{ trans('common.pass_maxlength_valid') }}'
                },
            }
        });
    });
</script>
