<?php
set_time_limit( 3600 ); 
ignore_user_abort( true ); 

//
// SendGrid PHP Library Example
//
// This example shows how to send email through SendGrid
// using the SendGrid PHP Library.  For more information
// on the SendGrid PHP Library, visit:
//
//     https://github.com/sendgrid/sendgrid-php
//

require("sendgrid-php.php");

include '../cadastro/password.php';

/* CREATE THE SENDGRID MAIL OBJECT
  ==================================================== */
$sendgrid = new SendGrid($sg_username, $sg_password);
$mail = new SendGrid\Email();

//$sexo="F";
//$nome="Profissional";
//$email="paulo.e.nery@uol.com.br";

$entityBody = file_get_contents('../email/bemvindoprofissional.json', true);
$mail_titi = file_get_contents('../email/mail-titi-profissional.html', true);
$arrayBody = [json_decode($entityBody, TRUE)];

$subject = (isset($arrayBody [0] ["subject"]) ? $arrayBody [0] ["subject"] : "");

if ($sexo == 'F') {
    $subject = str_replace("[Vindo]","vinda",$subject);
} else {
    $subject = str_replace("[Vindo]","vindo",$subject);
}

$text = (isset($arrayBody [0] ["text"]) ? $arrayBody [0] ["text"] : "");
$html = (isset($arrayBody [0] ["html"]) ? $arrayBody [0] ["html"] : "");
$text = str_replace("[nome]",$nome,$text);
$mail_titi = str_replace("[nome]",$nome,$mail_titi);
$mail_titi = str_replace("[texto]",$html,$mail_titi);

/* SEND MAIL
  /  Replace the the address(es) in the setTo/setTos
  /  function with the address(es) you're sending to.
  ==================================================== */
try {
    $mail->
            setFrom("titi@titicuidadores.com.br")->
            addTo($email)->
            addBcc("titi@titicuidadores.com.br")->
            setSubject($subject)->
            setText($text)->
            setHtml($mail_titi);

    $response = $sendgrid->send($mail);
    //var_dump($mail) ;
    /*
      if (!$response) {
      throw new Exception("Did not receive response.");
      } else if ($response->message && $response->message == "error") {
      throw new Exception("Received error: ".join(", ", $response->errors));
      } else {
      print_r($response);
      }
     */
} catch (Exception $e) {
    var_export($e);
}
?>
