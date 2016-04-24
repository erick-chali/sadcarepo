<?php
include ('../verifysession.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <title>Repositorio | FTP</title>
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

            <a class="navbar-brand" href="dashboard.php">Usuario</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="material-icons">menu</i>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="crear.php">Crear</a></li>
                <li><a href="">Cambiar mi contrase&ntilde;a</a></li>

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
            <h4>Subir arcchivos.</h4>
            <form method="post" action="upload.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Seleccione opci&oacute;n</label>
                    <select class="form-control input-sm" id="opcion" name="opcion">
                        <option value="5">Opcion 5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Archivos</label>
                    <input type="file" name="file[]" id="file" required multiple>
                </div>
                <span id="pt"></span>
                <button type="submit" class="btn btn-primary" id="btn_upload">Subir archivos</button>
            </form>
        </div>
    </div>


</div> <!-- /container -->

<script src="../js/jquery-2.2.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script src="../js/upload.js"></script>
<script type="text/javascript">
    document.getElementById('btn_upload').addEventListener('click', function (e) {
        e.preventDefault();
        var f = document.getElementById('file'),
            pt = document.getElementById('pt'),
            op = document.getElementById('opcion');
        app.uploader({
            files : f,
            opcion: op,
            progressText: pt,
            processor: 'upload.php',
            finished: function (data) {
                console.log(data);
                console.log('listo');
            },
            error: function () {
                console.log('No funciona.');
            }
        });
    });
//    (function(yourcode) {
//        yourcode(window.jQuery, window, document);
//    }(function($, window, document) {



        
//        $(function() {
//
//            $.ajax({
//                url: 'download.php',
//                method: 'POST',
//                dataType: 'json',
//                data: {
//                    action: 'cargarlistado'
//                },
//                type: 'post',
//                success: function(response) {
//                    window.location.href = response.URL;
//                }
//            });
//
//        });

        // The rest of the code goes here!


//    }));
</script>
</body>
</html>
