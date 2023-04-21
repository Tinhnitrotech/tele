<script type="text/javascript">
    $(document).ready(function () {
        $('#register-admin-form').validate({
            errorClass: 'error is-invalid',
            rules: {
                name: {
                    required: true,
                    maxlength: 100,
                },
                name_kana: {
                    required: true,
                    maxlength: 100,
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 100,
                },
                birthday: {
                    required: true,
                    date: true
                },
                gender: {
                    required: true,
                    digits: true,
                },
                password: {
                    required: true,
                    maxlength: 15,
                    minlength: 8,
                }
            },
            messages: {
                name: {
                    required: '{{ trans('validation_form.validate.name_admin.required') }}',
                    maxlength: '{{ trans('common.name_maxlength_valid') }}'
                },
                name_kana: {
                    required: '{{ trans('validation_form.validate.name_admin_kana.required') }}',
                    maxlength: '{{ trans('common.name_maxlength_valid') }}'
                },
                email: {
                    required: '{{ trans('validation_form.validate.email.required') }}',
                    email: '{{ trans('validation_form.validate.email.email') }}',
                    maxlength: '{{ trans('validation_form.validate.email.max') }}'
                },
                birthday: {
                    required: '{{ trans('validation_form.validate.birthday.required') }}',
                    date: '{{ trans('validation_form.validate.birthday.date') }}',
                },

                gender: {
                    required: '{{ trans('validation_form.validate.gender.required') }}',
                    digits: '{{ trans('validation_form.validate.gender.digits_between') }}',
                },
                password: {
                    required: '{{ trans('validation_form.validate.password.required') }}',
                    minlength: '{{ trans('validation_form.validate.password.min') }}',
                    maxlength: '{{ trans('validation_form.validate.password.max') }}'
                }
            }
        });
    });
</script>
