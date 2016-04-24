<?php
include('login.php'); // Includes Login Script

if(!isset($_SESSION['login_user_error'])){
    $_SESSION['login_user_error'] = '';
}
if(isset($_SESSION['login_user'])){
    header("location: usuario/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>Inicio de Sesi&oacute;n</title>
</head>

<body>

<div class="container">
    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }
        .form-signin .checkbox {
            font-weight: normal;
        }
        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
    <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Inicio de Sesi&oacute;n</h2>
        <label for="inputEmail" class="sr-only">Usuario</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Usuario"  autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Contrase&ntilde;a" >

        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
        <span class="text-danger"><?php echo $error; ?></span>
        <span class="text-danger"><?php echo $_SESSION['login_user_error']; ?></span>
    </form>

</div> <!-- /container -->

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
