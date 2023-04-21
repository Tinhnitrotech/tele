$('[data-target="#modal_confirm_delete"]').on('click', function (e) {
    var url = $(this).data('url');
    $('#deleteForm').attr('action', url);
});

