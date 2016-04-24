<?php
header('Content-Type: application/json');
$recibidos = [];
$permitidos = ['jpg','png','exe','txt','pdf'];

$subidos = [];
$fallidos = [];

$ftp_server = 's203601.gridserver.com';
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, 'psao@sadca.com', '}y4}cSGu_8k');
ftp_pasv($ftp_conn, true);
//$local_file = "../documentos/PRUEBA.pdf";
//$server_file = "Documentos/";

if(!empty($_FILES['file'])){

    foreach ($_FILES['file']['name'] as $key => $name){
        if ($_FILES['file']['error'][$key] === 0){
            $temp = $_FILES['file']['tmp_name'][$key];

            $ext = explode('.', $name);
            $ext = strtolower(end($ext));
//            $file = md5_file($temp).time().'.'.$ext;
            $file = $name;
//            if (in_array($ext, $permitidos)===true &&  move_uploaded_file($temp,"documentos/{$file}") === true){
                if (ftp_put($ftp_conn, '/documentos/'.$name,$temp , FTP_BINARY)=== true){
                    $subidos[] = array(
                        'name' => $name,
                        'file' => $file
                    );
                }else{
                    $fallidos[] = array(
                        'name' => $name,
                        'file' => $file
                    );
                }

//            }
        }
    }
    ftp_close($ftp_conn);
    if (!empty($_POST['ajax'])){
        echo json_encode(array(
            'subidos' => $subidos,
            'fallidos' => $fallidos,
            'opcion' => $_POST['opcion']
        ));
    }
}
//$conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
//
//
//
//$sql = 'CALL usuarioDelete(:codigo)';
//$stmt = $conn->prepare($sql);
//
//$stmt->bindParam(':codigo', $_POST['codigo_usuario'], PDO::PARAM_INT);
//$stmt->execute();
//
//$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//header('Content-Type: application/json');
//echo json_encode($result);