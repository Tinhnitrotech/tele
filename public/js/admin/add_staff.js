var date = $("#date_picker").val();
$("#date_picker").datepicker({ format: 'yyyy/mm/dd' }).datepicker("setDate", date ? date : '');

$("#datepicker").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'yyyy/mm/dd',
    endDate: new Date(),
});