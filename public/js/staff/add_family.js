$(document).ready(function () {

    let is_render = 1;

    $(document).on("input change paste keyup", ".check_postcode", function() {
        if ($('#scan_image').val() != 1) {
            AjaxZip3.zip2addr('postal_code_1', 'postal_code_2', 'prefecture_id', 'address', 'address_default', '');
        } else {
            AjaxZip3.zip2addr('postal_code_1', 'postal_code_2', 'prefecture_id', 'address_default', 'address_default', '');
        }
    });

    /** Add Row */
    const personMax = $('#person_max').data('max');
    let persomMaxMes = $('#person_max').text();
    let mesRemovePerson = $('#mes_remove_person').text();

    $('#add_family').on('click', function (e) {
        e.preventDefault();
        let countTotalRow = countRow();
        if (countTotalRow < personMax) {
            countTotalRow = parseInt(countTotalRow) + 1;
            $("#family_content").append(htmlAddFamily(countTotalRow));
            /** Conver Input Full-size to Half-size */
            converInputElement('input[name="person['+countTotalRow+'][age]"]');
        } else {
            alert(persomMaxMes);
        }
    });

    // Import HTML family template
    let htmlAddFamily = (number) => {
        let html = $('#button_add_family_template').html()
        html = html.replace(/__number__/g, number);
        return html;
    };

    /** Remove Row */
    $('#family_content').on('click', '.remove-person', function(e) {
        e.preventDefault();
        let parentTr = $(this).parent().parent();
        let isOwner = parentTr.find('.owner_radio');

        if (isOwner.is(":checked")) {
            alert(mesRemovePerson);
        } else {
            let id = $(this).data('id');
            let removePersonIds = $('#remove_person_ids').val();

            if (typeof id !== "undefined" && id !== '') {
                if (removePersonIds === '') {
                    $('#remove_person_ids').val(id);
                } else {
                    $('#remove_person_ids').val(removePersonIds + ',' + id);
                }
            }

            parentTr.remove();
            setNumberRow();
        }
    });

    /** Count Row */
    function countRow() {
        let rowTable = $('#family_content').find('tr');
        let countRow = rowTable.length;
        return countRow;
    }
    /** Set Number Row */
    function setNumberRow() {
        let rowItem = $('#family_content').find('tr');
        $.each(rowItem, function(index, value) {
            let numberStt = (index + 1);
            $(value).find('.owner_radio').val(numberStt);
            $(value).find('.owner_radio').attr('id', 'owner_'+numberStt);
            $(value).find('.position-relative label').attr('for', 'owner_'+numberStt);

            $(value).find('.person-id').attr('name', 'person['+numberStt+'][id]');
            $(value).find('.person-name').attr('name', 'person['+numberStt+'][name]');
            $(value).find('.person-age').attr('name', 'person['+numberStt+'][age]');
            $(value).find('.person-gender').attr('name', 'person['+numberStt+'][gender]');
            $(value).find('.person-option').attr('name', 'person['+numberStt+'][option]');
            $(value).find('.person-note').attr('name', 'person['+numberStt+'][note]');
        });
    }

    $(document).on("input change paste keyup", ".check_postcode", function() {
        let address = $('#address').val();
        if(address) {
            is_render = 1;
        } else {
            is_render = 0;
        }
    });


    $(document).on("input change paste keyup", '#address', function() {
        if(is_render != 1) {
            let address = $('#address').val();
            $('#address_default').val(address)
        }
    });

    function detectImage(input) {
        $('.loading').removeClass("d-none");
        is_render = 0;
        $('#scan_image').val(1);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                let content = e.target.result;
                var options = {};
                options.url = "/register/ajax_detect_image";
                options.type = "POST";
                options.headers = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
                options.data = JSON.stringify({content});
                options.dataType = "json";
                options.contentType = "application/json";
                options.success = function (result) {
                    $('.loading').addClass("d-none");
                    $('#family_content').empty();
                    $('#family_content').append(result.html_form);
                    $('#preview').addClass('d-none')
                    $('#address').val(result.user_info['address']);
                    $('#address_detect').val(result.user_info['address']);

                };
                options.error = function (err) {
                    $('.loading').addClass("d-none");
                    $('#preview').addClass('d-none')
                    $('.qr-scan').removeClass('d-none')
                    $('.error-scan').text('画像の読み取るにはエラーが発生しました。しばらく再度お試しください。')

                };

                $.ajax(options);

            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#capture_image").change(function(){
        detectImage(this);
    });

    function detectImage1(input) {
        $('.loading').removeClass("d-none");
        is_render = 0;
        $('#scan_image').val(1);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                let content = e.target.result;
                var options = {};
                options.url = "/register/ajax_detect_image_demo";
                options.type = "POST";
                options.headers = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
                options.data = JSON.stringify({content});
                options.dataType = "json";
                options.contentType = "application/json";
                options.success = function (response) {
                    if(!response) {
                        $('#textDetect').html('<div class="text-danger"> Can\'t find text in image!</div>')
                    } else {
                        var dataRes = JSON.parse(JSON.stringify(response))
                        if (dataRes.data === null) {
                            $('#textDetect').html('<div class="text-danger"> Can\'t find text in image!</div>')
                        } else {
                            var render = "";
                            $.each(dataRes.data, function( index, value ) {
                                render += "<div class='text-info'>";
                                render += "<p class='text-wrap'>" + value + "</p>";
                                render += "</div>";
                            });
                            $('#textDetect').html(render)
                        }
                    }
                    $('.loading').addClass("d-none");

                };
                options.error = function (xhr, ajaxOptions, thrownError) {
                    $('.loading').addClass("d-none");
                    $('#preview').addClass('d-none')
                    $('.qr-scan').removeClass('d-none')
                    $('.error-scan').text(thrownError)

                };

                $.ajax(options);

            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    async function detectImageDemo(input) {
        $('.loading').removeClass("d-none");
        is_render = 0;
        $('#scan_image').val(1);
        try {
            if(input.files && input.files[0]) {
                var form_data = new FormData();
                form_data.append('file', input.files[0]);
                await $.ajax({
                    url: '/register/ajax_detect_image_demo',
                    dataType: 'text',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (response) {

                        try {
                            if(!response) {
                                $('#textDetect').html('<div class="text-danger"> Can\'t find text in image!</div>')
                            } else {
                                var dataRes = JSON.parse(response)
                                if (dataRes.data === null) {
                                    $('#textDetect').html('<div class="text-danger"> Can\'t find text in image!</div>')
                                } else {
                                    var render = "";
                                    $.each(dataRes.data, function( index, value ) {
                                        render += "<div class='text-info'>";
                                        render += "<p class='text-wrap'>" + value + "</p>";
                                        render += "</div>";
                                    });
                                    $('#textDetect').html(render)
                                }
                            }
                        } catch (e) {
                            $('.error-scan').text('画像の読み取るにはエラーが発生しました。しばらく再度お試しください。')
                        } finally {
                            $('.loading').addClass("d-none");
                        }

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $('.loading').addClass("d-none");
                        $('#preview').addClass('d-none')
                        $('.qr-scan').removeClass('d-none')
                        // $('.error-scan').text('画像の読み取るにはエラーが発生しました。しばらく再度お試しください。')
                        $('.error-scan').text(thrownError)

                    },
                });
            }
        } catch (e) {
            $('.error-scan').text('画像の読み取るにはエラーが発生しました。しばらく再度お試しください。')
        }  finally {
            $('.loading').addClass("d-none");
        }

    }

    $("#capture_image_demo").change(function(){
        detectImageDemo(this);
    });


});
