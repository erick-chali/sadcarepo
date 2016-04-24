<?php
session_start();
session_unset($_SESSION['login_user']);
header("location: index.php");
