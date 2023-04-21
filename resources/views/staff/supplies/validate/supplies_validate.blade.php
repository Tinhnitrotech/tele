<script type="text/javascript">
    $(document).ready(function() {
        var rulesValid = {
            comment: {
                maxlength: 200,
            },
            note: {
                maxlength: 200,
            },
        };
        var rulesMes = {
            comment: {
                maxlength: '{{ trans('common.maxlength_valid_200') }}',
            },
            note: {
                maxlength: '{{ trans('common.maxlength_valid_200') }}',
            },
        };
        var countsupply = {{ $listMasterMaterial->isNotEmpty() ? $listMasterMaterial->count() : 1 }};

        for (var i = 1; i <= countsupply; i++) {
            rulesValid['supply['+i+'][m_supply_id]'] = {
                required: true,
                digits: true,
            };
            rulesValid['supply['+i+'][number]'] = {
                required: true,
                digits: true,
            };

            rulesMes['supply['+i+'][m_supply_id]'] = {
                required: '{{ trans('common.valid_required') }}',
                digits: '{{ trans('common.valid_positive_number') }}',
            };
            rulesMes['supply['+i+'][number]'] = {
                required: '{{ trans('common.valid_required') }}',
                digits: '{{ trans('common.valid_positive_number') }}',
            };
        }
        $('#supply-form').validate({
            errorClass: 'error is-invalid text-danger',
            errorPlacement: function (error, element) {
                if (error.text() !== '') {
                    element.parent().parent().find('.info_error').append(error);
                }
            },
            rules: rulesValid,
            messages: rulesMes
        });

    });
</script>
