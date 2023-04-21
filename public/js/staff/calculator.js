$(function () {
    /** Quantity */
    $('input.input-qty').each(function() {
        var $this = $(this);
        qty = $this.parent().find('.is-form');
        let currentVal = 0;

        // Click
        $(qty).on('click', function() {
            currentVal = $this.val();
            let valueCustom = currentVal.replaceAll(',', '')

            if ($(this).hasClass('minus')) {
                if(valueCustom == 0) {
                    return;
                }
                valueCustom = parseInt(valueCustom) - 1;
            } else if ($(this).hasClass('plus')) {
                valueCustom = parseInt(valueCustom) + 1;
            }
            let valueCover = parseInt(valueCustom).toLocaleString();
            $this.attr('value', valueCover).val(valueCover);
        });
    });
});

// Input
$(document).ready(function() {
    $( ".input-qty" ).keyup(function() {
        let currentVal = $(this).val();
        let valueCustom = currentVal.replaceAll(',', '')
        if (valueCustom != valueCustom.replace(/[^0-9\.]/g, '')) {
            $(this).attr('value', 0).val(0);
            return;
        }
        let newValue = parseInt(valueCustom).toLocaleString();
        if(!valueCustom) {
            $(this).attr('value', newValue).val(0);
        } else {
            $(this).attr('value', newValue).val(newValue);
            
        }
    });
});
