<?php
//require_once '../vendor/autoload.php';

if (file_exists('../db.xml')) {
    $xml = simplexml_load_file('../db.xml');
    echo $xml->datos->host;
//    print_r($xml);

} else {
    exit('Error abriendo test.xml.');
}