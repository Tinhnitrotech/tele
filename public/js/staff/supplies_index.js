$(function () {
    /** Quantity */
    $('input.input-qty').each(function() {
        var $this = $(this);
        qty = $this.parent().find('.is-form');
        min = 0;
        let currentVal = 0;

        $(qty).on('click', function() {
            currentVal = Number($this.val())

            if ($(this).hasClass('minus')) {
                if(currentVal == min) {
                    return;
                }
                currentVal = parseInt(currentVal) - 1;
            } else if ($(this).hasClass('plus')) {
                currentVal = parseInt(currentVal) + 1;
            }
            $this.attr('value', currentVal).val(currentVal);
        });
    });
});
