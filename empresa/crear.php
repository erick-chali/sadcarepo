<?php
include ('../verifysession.php');
include ('controller.php');
?>
<!DOCTYPE html>
<html lang="es">
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

            <a class="navbar-brand" href="dashboard.php">Empresa</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="material-icons">menu</i>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="crear.php">Crear</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="">Usuario: <?php echo $_SESSION['login_user']?></a></li>
                <li><a href=""></a></li>
                <li><a href="../logout.php">Cerrar Sesi&oacute;n</a></li>
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
    </style>
    <div class="col-lg-6 col-md-8 col-centered">
        <div class="well">
            <form id="formEditar">
                <h2 class="form-signin-heading">Nueva Empresa</h2>
                
                <div class="form-group">
                    <label for="nombre">Nombre de Empresa</label>
                    <input type="text" class="form-control input-sm" name="nombre" id="nombre" >
                </div>
                <div class="form-group">
                    <label for="pais">País</label>
                    <select name="pais", id="pais" class="form-control input-sm"></select>

                </div>
                <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="activo" id="activo"> Activo
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="actualizar">Crear</button>
                <div class="alert alert-danger" role="alert" id="alertaEditarError">
                    <ul>

                    </ul>
                </div>
                <div class="alert alert-success" role="alert" id="alertaEditarSuccess">
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
<script type="text/javascript">
    // IIFE - Immediately Invoked Function Expression
    (function(yourcode) {

        // The global jQuery object is passed as a parameter
        yourcode(window.jQuery, window, document);

    }(function($, window, document) {

        // The $ is now locally scoped

        // Listen for the jQuery ready event on the document
        $(function() {
            $('#alertaEditarSuccess').hide();
            $('#alertaEditarError').hide();
            $('#codigo_empresa').hide();
            $('#formEditar').submit(function () {

                $('#alertaEditarSuccess').hide();
                $('#alertaEditarError').hide();
                $('#alertaEditarError ul').empty();
                
                var activo = 0;
                
                if ($('#activo').is(":checked"))
                {
                    activo = 1;
                }
                $.ajax({
                    url: 'controller.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'create',
                        nombre: $('#nombre').val(),
                        pais: $('#pais').val(),
                        activo: activo
                    },
                    success: function(response) {
                        console.log(response);
                        var mensaje = '';
                        var resultado = 0;
                        $.each(response, function(k, v) {
                            mensaje = v.msj;
                            resultado = v.result;
                        });
                        if (resultado==1){
                            alert(resultado);
                            $('#alertaEditarSuccess p').text('Empresa creada.');
                            $('#alertaEditarSuccess').show();
//                            window.location.href = "../empresa/dashboard.php";
                        }else if(resultado == 0){
                            $('#alertaEditarError ul').text(mensaje);
                            $('#alertaEditarError').show();
                        }
                        if(response.errors.length > 0){
                            for (var i = 0; i < response.errors.length; i++) {
                                $('#alertaEditarError ul').append('<li>'+response.errors[i]+'</li>');
                                $('#alertaEditarError').show();
                            }
                        }
                    },
                    error: function (response) {
//                        var obj = JSON.parse(JSON.stringify(response));
//                        if (obj.status == 400){
//                            console.log(JSON.parse(JSON.stringify(response)));
//                            var objeto = obj.responseJSON;
//                            for (var i = 0; i < objeto.length; i++) {
//                                $('#alertaEditarError ul').append('<li>'+objeto[i]+'</li>')
//                            }
//                            $('#alertaEditarError').show();
//                        }

                    }

                }).done(function (response) {
                });
                return false;
            });
            $.ajax({
                url: '../pais/controller.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'select'
                },
                type: 'post',
                success: function(response) {
                    for (i = 0; i < response.length; i++) {
                        var arreglo = response[i];
                        $('#pais').append($('<option>', {
                            value: arreglo[0],
                            text : arreglo[1]
                        }));
                    }
                    var arreglo = response[0];
                }
            }).done(function (response) {
            });

        });

        //funciones


    }));
</script>
</body>
</html>