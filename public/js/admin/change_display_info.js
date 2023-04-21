function changeDisplayInfo(id) {
    if (id == '3' || id == '4') {
        $('.col-data-age').addClass("d-none");
    } else {
        $('.col-data-age').removeClass("d-none");
    }
    if (id == '2' || id == '4') {
        $('.col-data-address').addClass("d-none");
    } else {
        $('.col-data-address').removeClass("d-none");
    }
    $('#displayInfoMode').val(id);
    $(".paginate_button a.page-link").each(function()
    {
        this.href = this.href.replace(/display_option=[0-9]/, '');
        this.href = this.href.replace(/&page=/, 'display_option=' + id + '&page=');
        this.href = this.href.replace(/\?page=/, '?display_option=' + id + '&page=');
    });
}

changeDisplayInfo($('#displayInfoSelect').val());

