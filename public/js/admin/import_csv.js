$('#upload_csv_file').on("click",function() {
    $("#upload_progress").removeClass('d-none');
    $("#pageloader").removeClass('d-none');
    $("#upload_csv_file").addClass('d-none');
});

$('#download_zip_file').on("click",function() {
    $("#download_progress").removeClass('d-none');
    $("#pageloader").removeClass('d-none');
    $("#download_zip_section").addClass('d-none');
    $("#progress_info").addClass('d-none');

    setTimeout(function() {
        $("#download_progress").addClass('d-none');
        $("#pageloader").addClass('d-none');
        $("#download_zip_section").removeClass('d-none');
        $("#progress_info").removeClass('d-none');
    },10000);
}); 

if( $('#progress_reload').length ) {
    window.setTimeout(function(){location.reload()},5000);
}
