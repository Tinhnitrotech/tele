$(document).ready(function(){
    $('#submit_search').on('click', function () {
        if($('#memberRegisterForm').valid())  {
            var values = $("#memberRegisterForm").serialize();
            searchFamily(values)
        }
    });

    // Update user info
    function searchFamily(values){
        $.ajax({
            type: 'POST',
            url: '/register/jax_search',
            data: values,
            beforeSend: function () {
                $('#loading').removeClass("d-none");
                $('#search').addClass("d-none");
                $('#no-data').addClass("d-none");
                $('.loading').removeClass("d-none");
                $('#family_code_error').addClass("d-none");
                $('#password_error').addClass("d-none");
            },
            success:function(response){
                $('#loading').addClass("d-none");
                if (response.result) {
                    $('#family-code').text(family_code + ' ' + response.result.family_code)
                    $('#date-create').text(response.result.createdDate)
                    $('#address').text("〒" + response.result.zip_code + " " + response.result.address)
                    $('#phone-number').text(response.result.tel)
                    $('#family-detail').html(renderFamily(response.result.person));
                    $('#search').removeClass("d-none")
                    $('input#family_id').attr('value',response.result.id);

                } else {
                    $('#no-data').removeClass("d-none");
                    $('#no-data .card-box').text(no_data);
                }
            },

            complete:function(data) {
                $('html, body').animate({
                    scrollTop: $("#search").offset().top
                }, 1000);
            },

            error: function (errorMessage) {
                $('#loading').addClass("d-none");
                var err = JSON.parse(errorMessage.responseText);
                if(err.errors.family_code) {
                    $('#family_code_error').removeClass("d-none").text(err.errors.family_code)
                }
                if(err.errors.password) {
                    $('#password_error').removeClass("d-none").text(err.errors.password)
                }
            }
        });

        function renderFamily(person) {
            var render = "";
            $.each(person, function (id, item) {
                let note = item.note === null ? '--' : item.note;
                render += "<tr>";
                render += "<td>" + ++id + "</td>";
                render += "<td>" + checkOwner(item.is_owner) + "</td>";
                render += "<td>" + item.name + "</td>";
                render += "<td>" + item.age + "</td>";
                render += "<td>" + checkGender(item.gender) + "</td>";
                render += "<td>" + item.option + "</td>";
                render += "<td>" + note + "</td>";
                render += "<td>" + item.createdDate + "</td>";
                render += "</tr>";
            });
            return render;
        }

        function checkOwner(is_owner) {
            return !is_owner ? owner : "";
        }

        function checkGender(gender) {
            return ( gender == male_code ) ? male : female;
        }
    }
});
