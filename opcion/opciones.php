<?php
include('../verifysession.php');
$codigo_menu = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Repositorio - Opciones/Despliegue</title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-table.css">

</head>
<body>
<style>
    body {
        padding-top: 70px;
    }
    textarea {
        resize: vertical;
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

            <a class="navbar-brand" href="dashboard.php">Opciones</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="material-icons">menu</i>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

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
    <input type="text" value="<?php echo $codigo_menu;?>" id="codigo_menu" hidden>
    <h4 class="text-center">Seleccione una opci&oacute;n.</h4>
    <div class="col-lg-4 col-md-4">
        <div class="well">
            <form>
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" class="form-control input-sm" name="codigo_opcion" id="codigo_opcion" disabled>
                </div>
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control input-sm" name="nombre" id="nombre">
                </div>
                <div class="form-group">
                    <label>Descripci&oacute;n</label>
                    <textarea class="form-control" rows="2" name="descripcion" id="descripcion"></textarea>
                </div>
                <div class="form-group">
                    <label>Despliegue</label>
                    <input type="number" class="form-control input-sm" name="despliegue" id="despliegue">
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>

        </div>
    </div>
    <div class="col-lg-8 col-md-8">
        <table id="optionsTable">
        </table>
    </div>
</div>
</body>

<script type="text/javascript" src="../js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-table.min.js"></script>
<script type="text/javascript" src="../js/opciones.js">
    
</script>
</html>