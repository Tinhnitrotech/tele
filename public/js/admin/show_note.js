
$('[data-target="#modal_show_note"]').on('click', function (e) {
    var place = $(this).data('val');
    var placeName = $(this).data('name');
    $("#name_place").text(placeName);
    var noData = $("#no-data").val();
    $("#content-comment").text(place.comment ? place.comment: noData);
    $("#content-note").text(place.note ? place.note: noData);

});
