$('[data-target="#modal_confirm_change_active_status"]').on('click', function (e) {
    var url = $(this).data('url');
    $('#change_active_status').attr('action', url);
});
