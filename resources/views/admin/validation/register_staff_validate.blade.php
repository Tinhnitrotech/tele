<script type="text/javascript">
    $(document).ready(function () {
        jQuery.validator.addMethod("check_number_0_first", function (value) {
            if (!value) {
                return false;
            }
            var regex = /^0.*$/;
            return (regex.test(value))
        });
        $('#register-staff-form').validate({
            errorClass: 'error is-invalid',
            rules: {
                name: {
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
                tel: {
                    required: true,
                    digits: true,
                    check_number_0_first: true,
                    minlength: 10,
                    maxlength: 11
                }
            },
            messages: {
                email: {
                    required: '{{ trans('validation_form.validate.email.required') }}',
                    email: '{{ trans('validation_form.validate.email.email') }}',
                    maxlength: '{{ trans('validation_form.validate.email.max') }}'
                },
                name: {
                    required: '{{ trans('validation_form.validate.name_staff.required') }}',
                    maxlength: '{{ trans('common.name_maxlength_valid') }}'
                },
                birthday: {
                    required: '{{ trans('validation_form.validate.birthday.required') }}',
                    date: '{{ trans('validation_form.validate.birthday.date') }}',
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
                tel: {
                    required: '{{ trans('validation_form.validate.tel.required') }}',
                    digits: '{{ trans('validation_form.validate.tel.digits_between') }}',
                    check_number_0_first: '{{ trans('common.first_zero') }}',
                    minlength: '{{ trans('common.valid_tel') }}',
                    maxlength: '{{ trans('common.valid_tel') }}'
                }
            }
        });
    });
</script>
