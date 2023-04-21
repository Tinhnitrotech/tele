var getSum = function (colNumber) {
    var sum = 0;
    var selector = '.rowData' + colNumber;
    jQuery('#shortage-supply').find(selector).each(function (index, element) {
        sum += parseInt($(element).text());
    });
    return sum;
};
$('#shortage-supply').find('.total').each(function (index, element) {
    $(this).text(getSum(element.id) + $(this).text());
});
