$(document).ready(function () {

    $('#scanFrontCamera').on('click', function (){
        callCamera(1);
    })

    $('#scanBackCamera').on('click', function (){
        callCamera(2);
    })

    function callCamera(valueCamera) {

        let scanner = new Instascan.Scanner({video: document.getElementById('preview'), scanPeriod: 4, mirror:false });
        scanner.addListener('scan', function (content) {
            if (content.match(/^http?:\/10.\//i)) {
                window.open(content);
            } else {
                var options = {};
                options.url = "/register/jax_scan";
                options.type = "POST";
                options.headers = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
                options.data = JSON.stringify({content});
                options.dataType = "json";
                options.contentType = "application/json";
                options.success = function (result) {
                    $('#family_content').empty();
                    $('#family_content').append(result.html_form);
                    $('#postal_code_1').val(result.user_info['postal_code_1']).trigger("change");
                    $('#postal_code_2').val(result.user_info['postal_code_2']).trigger("change");
                    $('#tel').val(result.user_info['tel']);
                    $('#age').val(result.user_info['age']);
                    $('#gender').val(result.user_info['gender']);
                    $('#preview').addClass('d-none')
                    setTimeout(function() {
                        $('#address').val(result.user_info['address']);
                    }, 1500);
                };
                options.error = function (err) {
                    $('#preview').addClass('d-none')
                    $('.qr-scan').removeClass('d-none')
                    $('.error-scan').text('QRコードの読み取りにエラーが起きましたので、しばらく再度お試しください。')

                };

                $.ajax(options);
            }

            scanner.stop();
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            $('#preview').addClass('d-none')
            $('#preview').removeClass('d-none')
            scanner.stop(cameras[0]);
            scanner.stop(cameras[1]);
            scanner.stop();
            if (cameras.length > 0) {
                if (valueCamera == 1) {
                    if (cameras[0] != "") {
                        scanner.start(cameras[0]);
                    } else {
                        $('#preview').addClass('d-none')
                        $('.qr-scan').removeClass('d-none')
                        $('.error-scan').text('カメラが見つかりません。')
                    }
                } else if (valueCamera == 2) {
                    if (cameras[1] != "") {
                        scanner.start(cameras[1]);
                    } else {
                        $('#preview').addClass('d-none')
                        $('.qr-scan').removeClass('d-none')
                        $('.error-scan').text('カメラが見つかりません。')
                    }
                }

            } else {
                $('#preview').addClass('d-none')
                $('.qr-scan').removeClass('d-none')
                $('.error-scan').text('カメラが見つかりません。')
            }
        }).catch(function (e) {
            $('#preview').addClass('d-none')
            $('.qr-scan').removeClass('d-none')
            $('.error-scan').text('カメラが見つかりません。')
        });
    }
});
