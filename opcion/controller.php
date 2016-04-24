<?php

if (isset($_POST['action'])){
    if($_POST['action'] == 'select'){
        selectOptions();
    }
    if($_POST['action']== 'select_option'){
        select_option();
    }
    if($_POST['action']== 'select_option_files'){
        select_option_files();
    }
    if($_POST['action']== 'select_option_videos'){
        select_option_videos();
    }
}

function selectOptions(){
    $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
    // execute the stored procedure
    $sql = 'CALL opcionSelectAll(:codigo_menu)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':codigo_menu', $_POST['codigo_menu'], PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
}

function select_option(){
    $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
    // execute the stored procedure
    $sql = 'CALL opcionSelect(:codigo_opcion,:codigo_menu)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':codigo_opcion', $_POST['codigo_opcion'], PDO::PARAM_INT);
    $stmt->bindParam(':codigo_menu', $_POST['codigo_menu'], PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
}

function select_option_files(){
    $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
    // execute the stored procedure
    $sql = 'CALL opcion_archivoSelectAll(:codigo_opcion)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':codigo_opcion', $_POST['codigo_opcion'], PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
}

function select_option_videos(){
    $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
    // execute the stored procedure
    $sql = 'CALL opcion_videoSelectAll(:codigo_opcion)';
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':codigo_opcion', $_POST['codigo_opcion'], PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
}