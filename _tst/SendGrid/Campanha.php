<?php

set_time_limit(3600);
ignore_user_abort(true);

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


$mail_titi = file_get_contents('../email/mail-titi-campanha.html', true);

$subject = "Convite TITI Cuidadores Cuidadosos";

$html = 'Você foi pré-selecionado através de pesquisas no mercado de trabalho e gostaríamos de convida-lo para fazer parte da nossa plataforma.<br><br>'
        . 'O que é o TITI? TITI é uma plataforma que promove o encontro entre profissionais e famílias que buscam cuidados para idosos, crianças especiais e adultos com limitações de mobilidade. <br><br>'
        . 'Caso haja interesse em fazer parte desta comunidade responda este email que entraremos em contato. <br><br>'
        . 'TITI, tecnologia para unir pessoas apaixonadas por cuidar, à serviço da longevidade.<BR><BR>'
        . 'Uma ótima semana para você!<BR><BR>'
        . 'Um abraço do nosso time <BR><BR>'
        . 'TITI Cuidadores Cuidadosos<BR>'
        . 'www.titicuidadores.com.br<BR><BR>'
        . 'Curta nossa página no Facebook: https://www.facebook.com/TITICuidadores/';

function sendmail($nome, $email) {
    global $mail_titi, $html, $subject, $sendgrid ;
    $mail = new SendGrid\Email();

    $text = 'Olá, ' . $nome . ', tudo bem? \n\n' . $html;
    $text = str_replace("<br>", '\n', $text);
    $mail_titi2 = $mail_titi;
    $mail_titi2 = str_replace("[nome]", $nome, $mail_titi2);
    $mail_titi2 = str_replace("[texto]", $html, $mail_titi2);

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
                setHtml($mail_titi2);

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
}

?>
