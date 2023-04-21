<script type="text/javascript">
    $(document).ready(function() {
        // Datepicker setting current date
        @if (!empty($data['join_date']))
            let showDate = new Date('{{ $data['join_date'] }}');
        @else
            let showDate = new Date();
        @endif
        $("#date_picker").datepicker({ format: 'yyyy/mm/dd' }).datepicker("setDate", showDate);

        /* Validate */
        jQuery.validator.addMethod("check_number_0_first", function(value) {
            if (!value) {
                return false;
            }
            var regex = /^0.*$/;
            return (regex.test(value))
        });

        jQuery.validator.addMethod("check_password", function(value, element) {
            @if (empty($data['id']))
                let password = $('#add-family-form input[name="password"]').val();
                if (password === '') {
                    return false;
                }
            @endif

            return true;
        });

        const personMax = $('#person_max').data('max');
        var rulesValid = {
            join_date: {
                required: true,
                date: true,
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
            password: {
                digits: true,
                minlength: 4,
                maxlength: 8,
                check_password: true,
            },
            tel: {
                required: true,
                digits: true,
                check_number_0_first: true,
                minlength: 10,
                maxlength: 11
            },
            is_owner: {
                required: true,
            },
        };
        var rulesMes = {
            join_date: {
                required: '{{ trans('common.valid_required') }}',
                date: '{{ trans('common.evacuation_day_date') }}',
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
            password: {
                minlength: '{{ trans('user_register.validate.register.password.min') }}',
                maxlength: '{{ trans('user_register.validate.register.password.max') }}',
                digits: '{{ trans('user_register.validate.register.password.digit') }}',
                check_password: '{{ trans('common.valid_required') }}',
            },
            tel: {
                required: '{{ trans('validation_form.validate.tel.required') }}',
                digits: '{{ trans('validation_form.validate.tel.digits_between') }}',
                check_number_0_first: '{{ trans('common.first_zero') }}',
                minlength: '{{ trans('common.valid_tel') }}',
                maxlength: '{{ trans('common.valid_tel') }}'
            },
            is_owner: {
                required: '{{ trans('common.valid_required') }}',
            },
        };

        for (var i = 1; i <= personMax; i++) {
            rulesValid['person['+i+'][name]'] = {
                required: '#owner_'+i+':checked',
            };
            rulesValid['person['+i+'][age]'] = {
                required: '#owner_'+i+':checked',
                digits: true,
                min: 1,
                max:120
            };
            rulesValid['person['+i+'][gender]'] = {
                required: '#owner_'+i+':checked',
            };
            rulesValid['person['+i+'][note]'] = {
                maxlength: 200,
            };

            rulesMes['person['+i+'][name]'] = {
                required: '{{ trans('common.valid_required') }}',
            };
            rulesMes['person['+i+'][age]'] = {
                required: '{{ trans('common.valid_required') }}',
                digits: '{{ trans('common.valid_positive_number_age') }}',
                min: '{{ trans('common.minlength_age') }}',
                max:'{{ trans('common.maxlength_age') }}'
            };
            rulesMes['person['+i+'][gender]'] = {
                required: '{{ trans('common.valid_required') }}',
            };
            rulesMes['person['+i+'][note]'] = {
                maxlength: '{{ trans('user_register.validate.register.note.max') }}'
            };
        }

        $('#add-family-form').validate({
            errorClass: 'error is-invalid text-danger',
            rules: rulesValid,
            messages: rulesMes
        });

        /* Check validate input checkbox */
        $('.custom-control-label').on('click', function() {
            if ($('#customCheckAgree').hasClass('error is-invalid')) {
                $('#customCheckAgree').removeClass('error is-invalid');
            }
        });

        $('#add-family-form').on('submit', function(e) {
            e.stopPropagation();
            if (!$('#customCheckAgree').is(':checked')) {
                $('#customCheckAgree').addClass('error is-invalid');
                return false;
            }
        });

    });
</script>
