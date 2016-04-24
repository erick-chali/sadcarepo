<?php
include('../verifysession.php');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Repositorio - Usuario/Principal</title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">

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
                <li><a href="change_password.php?id=<?php echo $_SESSION['user_id']; ?>">Cambiar mi contrase&ntilde;a</a></li>

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

    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Empresa</th>
                <th>Pa&iacute;s</th>
                <th>Crea</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $conn = new mysqli('198.71.225.58','prepo','Ty~vj773','repositorio');
        $sql = "CALL usuariosSelectAll()";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result))
        {
            echo "<tr>";
            echo "<td>" . $row['codigo_usuario'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['usuario'] . "</td>";
            echo "<td>" . $row['e_mail'] . "</td>";
            echo "<td>" . $row['empresa'] . "</td>";
            echo "<td>" . $row['pais'] . "</td>";
            if ($row['crea_contenido'] == 1){
                echo "<td>" . 'Si'."</td>";
            }else{
                echo "<td>" . 'No'."</td>";
            }
            if ($row['activo'] == 1){
                echo "<td>" . 'Si'."</td>";
            }else{
                echo "<td>" . 'No'."</td>";
            }
            echo "<td>" . "<a role='button' href='editar.php?id=".$row['codigo_usuario']."' class='btn btn-primary btn-xs'>Editar</a>" .
                " <a role='button' href='eliminar.php?id=".$row['codigo_usuario']."' class='btn btn-danger btn-xs'>Eliminar</a>".
                " <a role='button' href='restore_password.php?id=".$row['codigo_usuario']."' class='btn btn-default btn-xs'>Restablecer</a>".
                "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>

<script type="text/javascript" src="../js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</html>