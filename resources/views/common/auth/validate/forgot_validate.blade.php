<script type="text/javascript">
    $(document).ready(function() {
        $('#telenet-forgot-form').validate({
            errorClass: 'error is-invalid',
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 100,
                },
            },
            messages: {
                email: {
                    required: '{{ trans('common.email_required_vaild') }}',
                    email: '{{ trans('common.email_valid') }}',
                    maxlength: '{{ trans('common.email_maxlength_valid') }}'
                },
            }
        });
    });
</script>
