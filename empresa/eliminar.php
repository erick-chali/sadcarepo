<?php
include ('../verifysession.php');
include ('controller.php');
$codigo_empresa = $_GET['id'];
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
                <h2 class="form-signin-heading">Eliminar Empresa</h2>
                <?php
                $conn = new mysqli('198.71.225.58','prepo','Ty~vj773','repositorio');
                $sql = "CALL empresasSelect(".$codigo_empresa.")";
                $result = mysqli_query($conn, $sql);
                ?>
                <?php
                while($row = mysqli_fetch_array($result)):?>
                    <input type="text" name="codigo_empresa" id="codigo_empresa" hidden value="<?php echo $row['codigo_empresa'];?>">

                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombre" id="nombre" disabled value="<?php echo $row['nombre'];?>">
                    </div>

                    <div class="form-group">
                        <label>Empresa</label>
                        <select class="form-control input-sm" name="pais" id="pais" disabled></select>
                        <input type="text" value="<?php echo $row['pais']?>" hidden id="codigo_pais">
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <?php if ($row['activo'] == 0):?>
                                <input type="checkbox" name="activo" id="activo" disabled> Activo
                            <?php else: ?>
                                <input type="checkbox" name="activo" id="activo" checked disabled> Activo
                            <?php endif;?>
                        </label>
                    </div>
                <?php endwhile;?>
                <button class="btn btn-lg btn-danger btn-block" type="submit" name="actualizar">Eliminar</button>
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
            $('#codigo_usuario').hide();
            $('#formEditar').submit(function () {

                $('#alertaEditarSuccess').hide();
                $('#alertaEditarError').hide();
                $('#alertaEditarError ul').empty();

                $.ajax({
                    url: 'controller.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'delete',
                        codigo_empresa: $('#codigo_empresa').val()
                    },
                    success: function(response) {
                        var mensaje = '';
                        var resultado = 0;
                        $.each(response, function(k, v) {
                            mensaje = v.msj;
                            resultado = v.result;
                        });
                        if (resultado==1){
                            $('#alertaEditarSuccess p').text('Empresa eliminada.');
                            $('#alertaEditarSuccess').show();
//                            window.location.href = "../usuario/dashboard.php";
                        }else if(resultado == 0){
                            $('#alertaEditarError ul').text(mensaje);
                            $('#alertaEditarError').show();
                        }
                        if(response.errors.length >0){
                            for (var i = 0; i < response.errors.length; i++) {
                                $('#alertaEditarError ul').append('<li>'+response.errors[i]+'</li>');
                                $('#alertaEditarError').show();
                            }
                        }
                    },
                    error: function (response) {
//                        var obj = JSON.parse(JSON.stringify(response));
//                        var objeto = obj.responseJSON;
//                        for (var i = 0; i < objeto.length; i++) {
//                            $('#alertaEditarError ul').append('<li>'+objeto[i]+'</li>')
//                        }
//                        $('#alertaEditarError').show();
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
                $('#pais').val($('#codigo_pais').val());
            });

        });

        // The rest of the code goes here!


    }));
</script>
</body>
</html>
