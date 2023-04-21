/** Conver Input Full-size to Half-size */
function toASCII(chars) {
    var ascii = '';
    for(var i=0, l=chars.length; i<l; i++) {
        var c = chars[i].charCodeAt(0);

        // make sure we only convert half-full width char
        if (c >= 0xFF00 && c <= 0xFFEF) {
            c = 0xFF & (c + 0x20);
        }

        ascii += String.fromCharCode(c);
    }

    return ascii;
}

function converInputElement(inputElm) {
    $(inputElm).on('keyup', function() {
        let inputElmVal = $(this).val();
        let cvInputElm = toASCII(inputElmVal);
        $(inputElm).val(cvInputElm);
    });
}

converInputElement('input[name="tel"]');
converInputElement('input[name="postal_code_1"]');
converInputElement('input[name="postal_code_2"]');
converInputElement('input[name="password"]');
converInputElement('input[name="total_place"]');
converInputElement('input[name="latitude"]');
converInputElement('input[name="longitude"]');
converInputElement('input[name="postal_code_default_1"]');
converInputElement('input[name="postal_code_default_2"]');

if ($('#person_max').length > 0) {
    let personMax = $('#person_max').data('max');
    for (var i = 1; i <= personMax; i++) {
        converInputElement('input[name="person['+i+'][age]"]');
    }
}

// Add postal code only number
function postalCode(id) {
    var element = document.getElementById(id);
    element.value = element.value.replace(/[^0-9]/gi, "");
}


$('.number_float').keypress(function(event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});
