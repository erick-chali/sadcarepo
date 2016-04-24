<?php
session_start(); //iniciamos una session.
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
    $_SESSION['login_user_error'] = '';
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Usuario y clave son requeridos.";
    }else{
    // Define $username and $password
        $username=$_POST['username'];
        $password=$_POST['password'];
        $username = stripslashes($username);
        $password = stripslashes($password);

        $mysql = mysqli_connect('198.71.225.58','prepo','Ty~vj773','repositorio');
        $rs = mysqli_query($mysql,"call login(".$username.",".$password.");");

        $sql = "CALL login_new('".$username."','".$password."')";
        $resultado = $mysql->query($sql);
        if($resultado->num_rows > 0)
        {
            while($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC))
            {
                $result = $row["result"];
                $message = $row["msj"];
                $id = $row['usrID'];
            }
        }
        if ($result == 1) {
            $_SESSION['login_user']=$username; // Initializing Session
            $_SESSION['user_id'] =  $id;
            header("location: usuario/dashboard.php"); // Redirecting To Other Page
        } else {
            $error = $message;
        }
        mysqli_close($mysql); // Closing Connection

    }
}