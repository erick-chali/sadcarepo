<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>http://blog.reaccionestudio.com/</title>
    <script src="../js/jquery-2.2.3.min.js"></script>
    <script>
//        var onloadCallback = function() {
//            grecaptcha.render('html_element', {
//                'sitekey' : '6LdynBoTAAAAAD0jC4SqZEJ0aM8upZrdIJmhIybb'
//            });
//        };
//        $(function(){
//
//            function captcha(){
//                var v1 = $("input#recaptcha_challenge_field").val();
//                var v2 = $("input#recaptcha_response_field").val();
//
//                $.ajax({
//                    type: "POST",
//                    url: "password_controller.php",
//                    data: "recaptcha_challenge_field="+v1+"&recaptcha_response_field="+v2,
//                    dataType: "html",
//                    error: function(){
//                        alert("error petición ajax");
//                    },
//                    success: function(data){
//                        alert(data);
//                    }
//                });
//
//            }
//
//            $("#boton").click(captcha);
//
//        });

    </script>
</head>

<body>
<form id="formpassword">
    <div class="g-recaptcha" data-sitekey="6LdynBoTAAAAAD0jC4SqZEJ0aM8upZrdIJmhIybb"></div>
    <br/>
    <input type="submit" value="Submit">
    <button type="button" id="btn">Boton</button>
</form>
<script src="https://www.google.com/recaptcha/api.js?hl=es-419" async defer></script>
<script type="text/javascript">
    (function(yourcode) {
        yourcode(window.jQuery, window, document);
    }(function($, window, document) {
        $(function() {

            $('#formpassword').submit(function (e) {
                var respuesta = null;
                respuesta = $('#g-recaptcha-response').val();
                if(respuesta == ''){
                    alert('debe responder el captcha');
                }else{
                    console.log('respuesta jquery: '+respuesta);
                    $.ajax({
                        url: 'password_controller.php',
                        dataType: 'json',
                        method: 'POST',
                        data: {
                            respuesta: respuesta
                        },
                        success: function (data) {
                            console.log(data);
                            document.getElementById("formpassword").reset();
                        }
                    });
                }
                return false;
            });

            $('#btn').click(function () {
                console.log('respuesta boton: ' +grecaptcha.getResponse());
            })
        });

    }));
</script>
</body>
</html>