<?php

//header('Content-Type: application/json');
//echo json_encode($_FILES["FileInput"]);
//exit();
//if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK)

if(isset($_FILES["FileInput"]))
{
    ############ Edit settings ##############
    $UploadDirectory	= 'documentos/'; //specify upload directory ends with / (slash)
    ##########################################

    /*
    Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini".
    Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit
    and set them adequately, also check "post_max_size".
    */

    //check if this is an ajax request

    foreach ($_FILES['FileInput']['name'] as $key => $name){
        $ftp_server = 's203601.gridserver.com';
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, 'psao@sadca.com', '}y4}cSGu_8k');
        ftp_pasv($ftp_conn, true);
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
            die();
        }


        //Is file size is less than allowed size.
        if ($_FILES["FileInput"]["size"][$key] > 5242880) {
            echo('<li> <h5 class="text-danger">'.'Tamano de archivo: <strong>'.$_FILES['FileInput']['name'][$key].'</strong> es mayor al permitido.</h5></li>');
        }else{

            $bloqueados = ['.xls','.txt'];
            //allowed file type Server side check
//            switch(strtolower($_FILES['FileInput']['type'][$key]))
//            {
//                //allowed file types
//                case 'image/png':
//                case 'image/gif':
//                case 'image/jpeg':
//                case 'image/pjpeg':
//                case 'text/plain':
//                case 'text/html': //html file
//                case 'application/x-zip-compressed':
//                case 'application/pdf':
//                case 'application/msword':
//                case 'application/vnd.ms-excel':
//                case 'video/mp4':
//                    break;
//                default:
//                    echo('<li> <h5>'.'Archivo: <strong>'.$_FILES['FileInput']['name'][$key].'</strong> es de tipo no soportado, contacte Administrador.</h5></li>');
//            }

            $File_Name          = strtolower($_FILES['FileInput']['name'][$key]);
            $File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
            $Random_Number      = rand(0, 9999999999); //Random number to be added to name.
            $NewFileName 		= $Random_Number.$File_Ext; //new file name

            if(in_array($File_Ext, $bloqueados)===true){
                echo('<li> <h5 class="text-danger">'.'Archivo: <strong>'.$_FILES['FileInput']['name'][$key].'</strong> es de tipo no soportado, contacte Administrador.</h5></li>');
            }else{
                $active = 1;
                $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
                $sql = 'CALL opcion_archivoInsert(:codigo,:nombre,:archivo,:activo)';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':codigo', $_POST['opcion'], PDO::PARAM_INT);
                $stmt->bindParam(':nombre', basename($_FILES['FileInput']['name'][$key], $File_Ext) , PDO::PARAM_STR);
                $stmt->bindParam(':archivo', $_FILES['FileInput']['name'][$key], PDO::PARAM_STR);
                $stmt->bindParam(':activo', $active , PDO::PARAM_BOOL);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $resultado = 0;
                $mensaje = '';
                foreach ($result as $dato){
                    $resultado = $dato['result'];
                    $mensaje = $dato['msj'];
                }
                if ($resultado == 1){
                    if(ftp_put($ftp_conn, '/documentos/'.$File_Name,$_FILES['FileInput']['tmp_name'][$key] , FTP_BINARY)=== true)
                    {
                        echo('<li> <h5>'.'Archivo: <strong>'.$_FILES['FileInput']['name'][$key].'</strong> subido exitosamente.</h5></li>');
                    }else{
                        echo('<li> <h5>'.'Archivo: <strong>'.$_FILES['FileInput']['name'][$key].'</strong> no pudo ser guardado, intente nuevamente.</h5></li>');
                    }
                }else{
                    echo('<li> <h5 class="text-danger">'.'<strong>'.$_FILES['FileInput']['name'][$key].'</strong>: '.$mensaje.'</h5></li>');
                }
            }

            ftp_close($ftp_conn);
        }


    }
}
else
{
    die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}