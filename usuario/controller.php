<?php
$record_ok = '';
if (isset($_POST['action'])){
    if($_POST['action'] == 'update'){
        updateUser();
    }
    if($_POST['action']== 'delete'){
        deleteUser();
    }
    if($_POST['action']== 'create'){
        createUser();
    }
}
function createUser(){
    $errors = array();
    if(!isset($_POST['nombre']) || $_POST['nombre'] == ''){
        array_push($errors, 'El campo nombre es requerido');
    }
    if(!isset($_POST['empresa']) || $_POST['empresa'] == ''){
        array_push($errors, 'El campo empresa es requerido');
    }
    if(!isset($_POST['email']) || $_POST['email'] == ''){
        array_push($errors, 'El campo email es requerido');
    }else if(!preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/", $_POST['email'])){
        array_push($errors, 'El email no es un correo valido.');
    }
    if(!isset($_POST['usuario']) || $_POST['usuario'] == ''){
        array_push($errors, 'El campo usuario es requerido');
    }else if(trim(strlen($_POST['usuario']))<6){
        array_push($errors, 'El usuario debe contener almenos 6 caracteres');
    }
    if(!isset($_POST['password']) || $_POST['password'] == ''){
        array_push($errors, 'El campo password es requerido');
    }else if(trim(strlen($_POST['password']))<8){
        array_push($errors, 'El password debe contener almenos 8 caracteres');
    }
    if(count($errors)>0){

//        header('HTTP/1.1 400 Bad Request Faltan Datos');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array("errors"=>$errors)));
    }else{
        if ($_POST['crea_contenido']=='0'){
            $contenido = 0;
        }else{
            $contenido = 1;
        }
        if ($_POST['activo']=='0'){
            $activo = 0;
        }else{
            $activo = 1;
        }
        $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
        // execute the stored procedure
        $sql = 'CALL usuariosInsert(:empresa,:nombre,:email,:usuario,:password,:contenido,:activo)';
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':empresa', $_POST['empresa'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $_POST['usuario'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
        $stmt->bindParam(':contenido', $contenido, PDO::PARAM_BOOL);
        $stmt->bindParam(':activo', $activo, PDO::PARAM_BOOL);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
function deleteUser(){
    $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
    // execute the stored procedure
    $sql = 'CALL usuarioDelete(:codigo)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':codigo', $_POST['codigo_usuario'], PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
}
function updateUser(){
    $errors = array();
    if(!isset($_POST['nombre']) || $_POST['nombre'] == ''){
        array_push($errors, 'El campo nombre es requerido');
    }
    if(!isset($_POST['empresa']) || $_POST['empresa'] == ''){
        array_push($errors, 'El campo empresa es requerido');
    }
    if(!isset($_POST['email']) || $_POST['email'] == ''){
        array_push($errors, 'El campo email es requerido');
    }else if(!preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/", $_POST['email'])){
        array_push($errors, 'El email no es un correo valido.');
    }
    if(!isset($_POST['usuario']) || $_POST['usuario'] == ''){
        array_push($errors, 'El campo usuario es requerido');
    }else if(trim(strlen($_POST['usuario']))<6){
        array_push($errors, 'El usuario debe contener almenos 6 caracteres');
    }
    if(count($errors)>0){

//        header('HTTP/1.1 500 Internal Server Faltan Datos');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array("errors"=>$errors)));
    }else{
        if ($_POST['crea_contenido']=='0'){
            $contenido = 0;
        }else{
            $contenido = 1;
        }
        if ($_POST['activo']=='0'){
            $activo = 0;
        }else{
            $activo = 1;
        }
        $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
        // execute the stored procedure
        $sql = 'CALL usuariosUpdate(:codigo,:empresa,:nombre,:email,:usuario,:contenido,:activo)';
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':codigo', $_POST['codigo_usuario'], PDO::PARAM_INT);
        $stmt->bindParam(':empresa', $_POST['empresa'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_INT);
        $stmt->bindParam(':usuario', $_POST['usuario'], PDO::PARAM_INT);
        $stmt->bindParam(':contenido', $contenido, PDO::PARAM_BOOL);
        $stmt->bindParam(':activo', $activo, PDO::PARAM_BOOL);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//        foreach ($result as $dato){
//            $msj = $dato['msj'];
//            $resultado = $dato['result'];
//        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}

