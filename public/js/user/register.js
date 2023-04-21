$(document).ready(function(){
    var num = 1;
    $('#add_member').on('click', function () {
        num = parseInt(num) + 1;
        $(".member").last().append(htmlFamilyImport(num))
    });

    // Import HTML family template
    let htmlFamilyImport = (number) => {
        let html = $('#input_template_family').html()
        html = html.replace(/__number__/g, number);
        return html;
    };

    // Datepicker setting current date
    $("#date_picker").datepicker({ format: 'yyyy/mm/dd' }).datepicker("setDate", new Date());

});
