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

$mail_titi = file_get_contents('../email/mail-titi-cliente.html', true);

$subject = "Bem [Vindo] ao TITI Cuidadores Cuidadosos";

if ($sexo == 'F') {
    $subject = str_replace("[Vindo]","vinda",$subject);
} else {
    $subject = str_replace("[Vindo]","vindo",$subject);
}


$html =   'Obrigado pelo seu cadastro e interesse na nossa plataforma. <BR><BR>'
        . 'Nos colocamos à sua inteira disposição para quaisquer dúvidas ou esclarecimentos, '
        . 'e queremos que você continue conosco, acompanhando a evolução da plataforma que iniciou há dois meses.<BR><BR><BR>'
        . 'Uma ótima semana para você e feliz ano novo!<BR><BR>'
        . 'Um abraço do nosso time <BR><BR><BR> '
        . 'TITI Cuidadores Cuidadosos<BR><BR>'
        . 'www.titicuidadores.com.br<BR><BR><BR>'
        . 'Curta nossa página no Facebook: https://www.facebook.com/TITICuidadores/';


$text = 'Olá, '.$nome.', tudo bem? \n\n' . $html;
$text = str_replace("<br>", '\n', $text);
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
    //var_export($e);
}
?>
