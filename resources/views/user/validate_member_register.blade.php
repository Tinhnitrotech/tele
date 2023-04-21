<script type="text/javascript">
    $(document).ready(function() {
         // Validate form
        $("#memberRegisterForm").validate({
            rules: {
                family_code:  {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 4,
                    maxlength: 8,
                    digits: true
                }
            },
            messages: {
                family_code:  {
                    required: '{{ trans('user_register.validate.member.family_code.required') }}',
                },
                password: {
                    required: '{{ trans('user_register.validate.member.family_password.required') }}',
                    maxlength: '{{ trans('user_register.validate.member.family_password.max') }}',
                    minlength : '{{ trans('user_register.validate.member.family_password.min') }}',
                    digits : '{{ trans('user_register.validate.member.family_password.digit') }}',
                 },
            }
        });
    });
</script>
