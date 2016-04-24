<?php
require_once "../vendor/autoload.php";
if(isset($_POST['action'])){
    if($_POST['action'] == 'restore'){
        restore_password();
    }if($_POST['action'] == 'change'){
        change_password();
    }
}
function change_password(){
    header('Content-Type: application/json; charset=UTF-8');
    $errors = [];
    $response = [];

    if (!isset($_POST['new_password']) || $_POST['new_password'] == ''){
        array_push($errors, 'Debe ingresar la nueva clave.');
    }else if(strlen(preg_replace('/\s+/', '', $_POST['new_password'])) < 8){
        array_push($errors, 'La nueva clave debe ser de almenos 8 caracteres.');
    }
    if (!isset($_POST['repeat_new_password']) || $_POST['repeat_new_password'] == ''){
        array_push($errors, 'Debe repetir la nueva clave.');
    }else if (!($_POST['repeat_new_password'] == $_POST['new_password'])){
        array_push($errors, 'Las claves no coinciden, por favor revise');
    }

    if (count($errors)>0){
        die(json_encode(array('errors'=>$errors, 'response'=>$response)));
    }else{
        $conn = new PDO("mysql:host=198.71.225.58;dbname=repositorio", 'prepo', 'Ty~vj773');
        // execute the stored procedure
        $sql = 'CALL updatePsw(:codigo,:password,:restablece)';
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':codigo', $_POST['codigo_usuario'], PDO::PARAM_INT);
        $stmt->bindParam(':password', $_POST['new_password'], PDO::PARAM_INT);
        $stmt->bindParam(':restablece', $activo, PDO::PARAM_BOOL);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array('errors'=>$errors, 'response'=>$result));
    }
}
function restore_password(){

    $string_key = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $captcha = $_POST['respuesta'];
    $errors = [];
    $response = [];
    if (isset($_POST['respuesta']) && $_POST['respuesta'] != ''){
        $respuesta = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?".//direccion predefinida (debe ser la de la documentacion oficial)
            "secret=6LdynBoTAAAAAPdGrGq-zhhzdy4RQY9ICiA53RSl".// la private key del sitio
            "&response=".$captcha
        ),true);
        if ($respuesta['success']== false){

            array_push($errors, 'spammer detected');
            echo json_encode(array('errors'=>$errors, 'response' => $response));
        }else{


            $new_password = get_random_string($string_key, 8);
            if(send_email('erickdemon@gmail.com', $new_password))
            {
                array_push($response, 'email sent');
                array_push($response, $new_password);
                echo json_encode(array('errors'=>$errors, 'response' => $response));
            }
            else
            {
                array_push($errors, 'email not send');
                array_push($errors, $new_password);
                echo json_encode(array('errors'=>$errors, 'response' => $response));
            }
        }
    }else{
        array_push($errors, 'spammer detected');
        echo json_encode(array('errors'=>$errors, 'response' => $response));
    }
}
function send_email($address, $password){
    $mail = new PHPMailer;
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "erick.chali93@gmail.com";
    $mail->Password = "Inge.2014";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->From = "erick.chali93@gmail.com";
    $mail->FromName = "Erick Ejemplo";
    $mail->addAddress($address, "Erick Demon");

    $mail->isHTML(true);

    $mail->Subject = "Nueva clave";
    $mail->Body = "<i>".$password."</i>";
    $mail->AltBody = "This is yout password.";

    if($mail->send())
    {
        return true;
    }else{
        return false;
    }
}
function get_random_string($valid_chars, $length)
{
    // start with an empty random string
    $random_string = "";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}
