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


$mail_titi = file_get_contents('../email/mail-titi-profissional.html', true);

$subject = "Bem [Vindo] ao TITI Cuidadores Cuidadosos";

if ($sexo == 'F') {
    $subject = str_replace("[Vindo]","vinda",$subject);
} else {
    $subject = str_replace("[Vindo]","vindo",$subject);
}
$html =   'Obrigado pelo seu cadastro e interesse na nossa plataforma. '
        . 'Estamos bastante contentes em te receber.<BR><BR><BR>'
        . 'Você acessou nosso site e ficou com alguma outra dúvida? '
        . 'Se sim, nós queríamos conversar sobre isso, '
        . 'e também para fazermos uma entrevista que pode ser remota ou presencial, como preferir.<BR><BR><BR>'
        . 'Para nos enviar o seu CV, basta anexá-lo aqui na resposta desse e-mail, por favor. '
        . 'Mesmo que você seja formado em auxiliar ou técnico de enfermagem, e não tenha experiência nessa área, '
        . 'mas tenha alguma experiência como cuidador de idosos, mesmo que seja pessoal, nós queremos conhecer seu histórico.<BR><BR><BR>'
        . 'Aguardamos seu contato para avançarmos e você poder participar dessa nova plataforma que promete revolucionar o mercado.<BR><BR><BR>'
        . 'Uma ótima semana para você!<BR><BR>'
        . 'Um abraço do nosso time <BR><BR><BR>'
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
            setFrom("contato@titicuidadores.com.br")->
            addTo($email)->
            addBcc("contato@titicuidadores.com.br")->
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
