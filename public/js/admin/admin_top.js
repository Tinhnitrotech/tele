var getSum = function (colNumber) {
    var sum = 0;
    var selector = '.rowDataSd' + colNumber;
    jQuery('#admin_top_table').find(selector).each(function (index, element) {
        sum += parseInt($(element).text());
    });
    return sum;
};
$('#admin_top_table').find('.total').each(function (index, element) {
    $(this).text(getSum(index + 1) + $(this).text());
});

var getAverage = function (colNumber) {
    var sum = 0;
    var count = 0;
    var selector = '.rowDataSdAvg' + colNumber;
    jQuery('#admin_top_table').find(selector).each(function (index, element) {
        sum += parseFloat($(element).text());
        count++;
    });
    return (sum/count)? (sum/count).toFixed(2) : '0.00';
};
$('#admin_top_table').find('.average').each(function (index, element) {
    $(this).text(getAverage(index + 1) + $(this).text());
});