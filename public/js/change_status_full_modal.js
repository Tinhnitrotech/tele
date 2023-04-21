$('[data-target="#modal_confirm_change_status_full"]').on('click', function (e) {
    var url = $(this).data('url');
    $('#change_status_full').attr('action', url);
});

