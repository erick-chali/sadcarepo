<?php
$record_ok = '';
if (isset($_POST['action'])){
    if($_POST['action'] == 'select'){
        select();
    }
    if($_POST['action'] == 'update'){
        updatePais();
    }
    if($_POST['action']== 'delete'){
        deletePais();
    }
    if($_POST['action']== 'create'){

        createPais();
    }
}
function select(){

    $conn = new mysqli('198.71.225.58','prepo','Ty~vj773','repositorio');
    $sql = "CALL paisesSelectAll()";
    $result = mysqli_query($conn, $sql);
    $empresas = mysqli_fetch_all($result);
    header('Content-Type: application/json');
    echo json_encode($empresas);
}
function createPais(){
    $errors = array();
    if(!isset($_POST['descripcion']) || $_POST['descripcion'] == '') {
        array_push($errors, 'El campo descripcion es requerido');
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
            $sql = 'CALL paisesInsert(:descripcion,:activo)';
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':descripcion', $_POST['descripcion'], PDO::PARAM_STR);
            $stmt->bindParam(':activo', $activo, PDO::PARAM_BOOL);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode($result);
        }
}
function deletePais(){
    $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
    // execute the stored procedure
    $sql = 'CALL paisesDelelte(:codigo)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':codigo', $_POST['codigo_pais'], PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
}
function updatePais(){
    $errors = array();
    if(!isset($_POST['descripcion']) || $_POST['descripcion'] == ''){
        array_push($errors, 'El nombre del pais es requerido');
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
        $sql = 'CALL paisUpdate(:codigo,:descripcion,:activo)';
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':codigo', $_POST['codigo_pais'], PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $_POST['descripcion'], PDO::PARAM_STR);
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