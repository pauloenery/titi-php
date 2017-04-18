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
$subject = "Avaliação do Profissional";

$mail_titi = file_get_contents('../email/mail-titi-evaluate.html', true);
$html = 'Parabéns pelas avaliações que você recebeu!<br>';
$html .= 'Elas são uma ferramenta poderosa para o seu empoderamento e reconhecimento profissional.<br><br>';
$html .= 'O site TITI tem uma inteligência que faz com que o seu perfil apareça nas primeiras pesquisas dos Clientes e Pacientes quando você recebe mais e melhores notas!<br><br>';
$html .= 'Compartilhe com seus pacientes e ganhe mais visibilidade para poder brilhar ainda mais na sua história profissional!<br><br>';
$html .= 'Basta enviar esse link para eles: http://titicuidadores.com.br/_prd/evaluate/evaluate.php<br><br>';
$html .= 'Abaixo segue a última avaliação que você recebeu ';
$html .= 'de: <b>'.nome($nome) . '</b><br><br>';

// aqui o nome e a avaliação do paciente
$html .= 'Nota: <b>'.$myclass.'</b><br>';
$html .= 'Comentário: <b>'.$comentario.'</b><br><br><br>';
$html .= 'Uma ótima semana para você.<br><br>';
$html .= 'Um abraço do nosso time<br><br>';
$html .= 'TITI Cuidadores Cuidadosos<br>';
$html .= 'www.titicuidadores.com.br<br><br>';
$html .= 'Curta nossa página no Facebook: https://www.facebook.com/TITICuidadores/<br>';

$text = 'Olá, '.$nomeespecialista.', tudo bem? /n/n' . $html;
$text = str_replace("<br>", '/n', $text);
$text = str_replace("<b>", '', $text);
$text = str_replace("</b>", '', $text);
$mail_titi = str_replace("[texto]", $html, $mail_titi);
$mail_titi = str_replace("[nome]", $nomeespecialista, $mail_titi);
//Echo $emailespecialista;
//Echo $nomeespecialista;
//Echo $mail_titi;


/* SEND MAIL
  /  Replace the the address(es) in the setTo/setTos
  /  function with the address(es) you're sending to.
  ==================================================== */
try {
    $mail->
            setFrom("contato@titicuidadores.com.br")->
            addTo($emailespecialista)->
            addBcc("contato@titicuidadores.com.br")->
            setSubject($subject)->
            setText($text)->
            setHtml($mail_titi);

    $response = $sendgrid->send($mail);
    //var_dump($mail) ;
    
    //  if (!$response) {
    //  throw new Exception("Did not receive response.");
    //  } else if ($response->message && $response->message == "error") {
    //  throw new Exception("Received error: ".join(", ", $response->errors));
    //  } else {
    //  print_r($response);
    //  }
    
} catch (Exception $e) {
    var_export($e);
}

?>
