<?php
include '../verifysession.php';
$codigo_usuario = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
      xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <title>Inicio de Sesi&oacute;n</title>

</head>

<body>
<style>
    body {
        padding-top: 70px;
    }
    /* Rules for sizing the icon. */
    .material-icons.md-12 { font-size: 12px; }
    .material-icons.md-18 { font-size: 18px; }
    .material-icons.md-24 { font-size: 24px; }
    .material-icons.md-36 { font-size: 36px; }
    .material-icons.md-48 { font-size: 48px; }

    /* Rules for using icons as black on a light background. */
    .material-icons.md-dark { color: rgba(0, 0, 0, 0.54); }
    .material-icons.md-dark.md-inactive { color: rgba(0, 0, 0, 0.26); }

    /* Rules for using icons as white on a dark background. */
    .material-icons.md-light { color: rgba(255, 255, 255, 1); }
    .material-icons.md-light.md-inactive { color: rgba(255, 255, 255, 0.3); }
</style>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <a class="navbar-brand" href="../index.php">Regresar</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="material-icons">menu</i>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

            </ul>
            <ul class="nav navbar-nav navbar-right">
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<div class="container">
    <style>
        .col-centered{
            float: none;
            margin: 0 auto;
        }
        /*.g-recaptcha div { margin-left: auto; margin-right: auto;}*/
        #captcha div {
            margin-left: auto; margin-right: auto;
        }
    </style>
    <div class="col-lg-6 col-md-8 col-centered">
        <div class="well">
            <form id="formRestablecer">
                <h2 class="form-signin-heading">Restablecer Contrase&ntilde;a</h2>
                <?php if($codigo_usuario == 0 || $codigo_usuario == null || $codigo_usuario == ''):?>
                    <input type="text" name="codigo_usuario" id="codigo_usuario" hidden>
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control input-sm" name="usuario" id="usuario">
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nueva Clave</label>
                        <input type="password" class="form-control input-sm" name="new_password" id="new_password">
                    </div>
                    <div class="form-group">
                        <label for="repeat_new_password">Repetir Nueva Clave</label>
                        <input type="password" class="form-control input-sm" name="repeat_new_password" id="repeat_new_password">
                    </div>
<!--                    <div class="g-recaptcha" data-sitekey="6LdynBoTAAAAAD0jC4SqZEJ0aM8upZrdIJmhIybb" id="captcha"></div>-->
                    <div id="captcha"></div>
                    </br>
                <?php else: ?>
                    <?php
                    $conn = new mysqli('198.71.225.58','prepo','Ty~vj773','repositorio');
                    $sql = "CALL usuariosSelect(".$codigo_usuario.")";
                    $result = mysqli_query($conn, $sql);
                    ?>
                    <?php
                    while($row = mysqli_fetch_array($result)):?>
                        <input type="text" name="codigo_usuario" id="codigo_usuario" value="<?php echo $row['codigo_usuario'] ?>" hidden>
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control input-sm" name="usuario" id="usuario" value="<?php echo $row['usuario']?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nueva Clave</label>
                            <input type="password" class="form-control input-sm" name="new_password" id="new_password">
                        </div>
                        <div class="form-group">
                            <label for="repeat_new_password">Repetir Nueva Clave</label>
                            <input type="password" class="form-control input-sm" name="repeat_new_password" id="repeat_new_password">
                        </div>
<!--                        <div class="g-recaptcha"  data-sitekey="6LdynBoTAAAAAD0jC4SqZEJ0aM8upZrdIJmhIybb" id="captcha"></div>-->
                        <div id="captcha"></div>
                        </br>
                    <?php endwhile; ?>
                <?php endif;?>

                <button class="btn btn-lg btn-primary btn-block" type="submit" name="restablecer" id="restablecer">Cambiar Contrase&ntilde;a</button>
                </br>
                <div class="alert alert-danger" role="alert" id="alertaError">
                    <ul>

                    </ul>
                </div>
                <div class="alert alert-success" role="alert" id="alertaSuccess">
                    <p>
                    </p>
                </div>
            </form>
        </div>
    </div>


</div> <!-- /container -->

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../js/jquery-2.2.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<!--<script src="https://www.google.com/recaptcha/api.js?hl=es-419" async defer></script>-->
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=es-419"
        async defer>
</script>
<script type="text/javascript">
    var onloadCallback = function() {
        grecaptcha.render('captcha', {
            'sitekey' : '6LdynBoTAAAAAD0jC4SqZEJ0aM8upZrdIJmhIybb',
            'theme' : 'dark',
            'callback' : function(response) {
                console.log(response);
            },
            'expired-callback' : function(response) {
                alert('El tiempo de vida del captcha se ha agotado, resuelvalo nuevamente.');
                grecaptcha.reset();
            }
        });
    };
</script>
<script type="text/javascript">
    (function(yourcode) {
        yourcode(window.jQuery, window, document);
    }(function($, window, document) {
        $(function() {

            $('#alertaSuccess').hide();
            $('#alertaError').hide();
            $('#codigo_usuario').hide();

            $('#formRestablecer').submit(function () {

                $('#alertaSuccess').hide();
                $('#alertaError').hide();
                $('#alertaError ul').empty();
                var respuesta = $('#g-recaptcha-response').val();
                if(respuesta == ''){
                    console.log('email: ' + $('#email').val());
                    console.log('id: ' + $('#codigo_usuario').val());
                    $('#alertaError ul').append('<li>'+'Debe resolver el captcha.'+'</li>');
                    $('#alertaError').show();
                }else{
                    $.ajax({
                        url: 'password_controller.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'change',
                            codigo_usuario: $('#codigo_usuario').val(),
                            new_password: $('#new_password').val(),
                            repeat_new_password: $('#repeat_new_password').val(),
                            respuesta: respuesta
                        },
                        success: function(response) {
                            console.log(JSON.stringify(response));
                            if(response.errors.length > 0){
                                for (var i = 0; i < response.errors.length; i++) {
                                    $('#alertaError ul').append('<li>'+response.errors[i]+'</li>');
                                    $('#alertaError').show();
                                }
                                grecaptcha.reset();
                            }
                            if(response.response.length > 0 ){
                                var mensaje = '';
                                var resultado = 0;
                                $.each(response.response, function(k, v) {
                                    mensaje = v.msj;
                                    resultado = v.result;
                                });
                                if(resultado == 1){
                                    $('#alertaSuccess p').text('Clave cambiada exitosamente');
                                    $('#alertaSuccess').show();
                                    window.setTimeout(function(){
                                        window.location.href = "../usuario/dashboard.php";
                                    }, 5000);
                                }
                            }
                        },
                        error: function (response) {
                            alert('error: ' + JSON.stringify(response));
                        }

                    }).done(function (response) {
                    });
                }

                return false;
            });

        });

        // The rest of the code goes here!


    }));
</script>
</body>
</html>
