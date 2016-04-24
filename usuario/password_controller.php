<?php
require_once "../vendor/autoload.php";
if(isset($_POST['action'])){
    if($_POST['action'] == 'restore'){
        restore_password();
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
