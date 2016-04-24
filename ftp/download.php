<?php
// connect and login to FTP server
//'host'   => '107.180.46.221',
//            'port'  => 21,
//            'username' => 'herpControlsApp',
//            'password'   => '~05>P9^_#kI0',
$ftp_server = '107.180.46.221';
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, 'herpControlsApp', '~05>P9^_#kI0');
ftp_pasv($ftp_conn, true);
$local_file = "../documentos/PRUEBA.pdf";
$server_file = "Documentos/HOLA.pdf";

// download server file
if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII))
{
    //CONTENT-DISPOSITION: PARA DESCARGA
//    header("Content-disposition: attachment; filename=" . "PRUEBA.pdf");
//    header("Content-type: application/pdf");
//    readfile($local_file);
    // CONTENIDO PARA DESCARGA
    header("Content-disposition: inline; filename=" . "PRUEBA.pdf");
    header("Content-type: application/pdf");
    readfile($local_file);
//    echo json_encode(array('URL'=>$local_file));
}
else
{
    echo "Error downloading $server_file.";
}

// close connection
ftp_close($ftp_conn);
?>