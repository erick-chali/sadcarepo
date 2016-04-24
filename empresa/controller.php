<?php

if (isset($_POST['action'])){
    if ($_POST['action'] == 'cargarlistado'){
        cargarlistado();
    }
    if($_POST['action'] == 'update'){
        updateEmpresa();
    }
    if($_POST['action']== 'delete'){
        deleteEmpresa();
    }
    if($_POST['action']== 'create'){
        createEmpresa();
    }
}

function cargarlistado(){

    $conn = new mysqli('198.71.225.58','prepo','Ty~vj773','repositorio');
    $sql = "CALL empresasSelectAll()";
    $result = mysqli_query($conn, $sql);
//    $empresas = mysqli_fetch_array($result);
    $empresas = mysqli_fetch_all($result);
    header('Content-Type: application/json');
    echo json_encode($empresas);
}

function createEmpresa(){
    $errors = array();
    if(!isset($_POST['nombre']) || $_POST['nombre'] == ''){
        array_push($errors, 'Ingrese el nombre de la empresa');
    }
    if(!isset($_POST['pais']) || $_POST['pais'] == ''){
        array_push($errors, 'Debe seleccionar un país del listado');
    }
    
    if(count($errors)>0){

//        header('HTTP/1.1 400 Bad Request Faltan Datos');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array("errors"=>$errors)));
    }else{
        
        if ($_POST['activo']=='0'){
            $activo = 0;
        }else{
            $activo = 1;
        }
        $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
        // execute the stored procedure
        $sql = 'CALL empresaInsert(:nombre,:pais,:activo)';
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':pais', $_POST['pais'], PDO::PARAM_STR);
        $stmt->bindParam(':activo', $activo, PDO::PARAM_BOOL);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($result);
    }
}


function deleteEmpresa(){
    $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
    // execute the stored procedure
    $sql = 'CALL empresaDelete(:codigo)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':codigo', $_POST['codigo_empresa'], PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
}
function updateEmpresa(){
    $errors = array();
    if(!isset($_POST['nombre']) || $_POST['nombre'] == ''){
        array_push($errors, 'El nombre de la empresa es requerido');
    }
    if(!isset($_POST['pais']) || $_POST['pais'] == ''){
        array_push($errors, 'El país de la empresa es requerido');
    }
    if(count($errors)>0){

//        header('HTTP/1.1 500 Internal Server Faltan Datos');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array("errors"=>$errors)));
    }else{
        
        if ($_POST['activo']=='0'){
            $activo = 0;
        }else{
            $activo = 1;
        }
        $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
        // execute the stored procedure
        $sql = 'CALL empresaUpdate(:codigo,:nombre_empresa,:codigo_pais,:activo)';
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':codigo', $_POST['codigo_empresa'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre_empresa', $_POST['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':codigo_pais', $_POST['pais'], PDO::PARAM_INT);
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
