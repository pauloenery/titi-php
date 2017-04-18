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
$subject = "Busca Profissional";

$mail_titi = file_get_contents('../email/mail-titi-busca.html', true);
$html = 'CEP: ' . $cep  . '<br>'
      . 'Profissional: ' . cargo($atuacao) . '<br><br>'
      . 'Identificamos que a pesquisa acima retornou ';
if ($i>1) {
    $html .= 'os profissionais: ';
}
else {
    $html .= 'o profissional: ';
}
for ($x = 0; $x < $i; $x++) {
    if ($x >= 1) {
        $html .= ", ";
    } 
    $html .= $retorno[$x]["nome"];
}
$html .=  ' e gostaríamos de saber se você teve oportunidade de entrar em contato com ';
        
if ($i>1) {
    $html .= 'eles';
}
else {
    $html .= 'ele';
}
$html .= ', ou se podemos te auxiliar de alguma outra maneira, por favor.<br><br>';
$html .= 'Nos colocamos à sua inteira disposição para quaisquer dúvidas ou esclarecimentos.<br><br>';
$html .= 'Uma ótima semana para você!<br><br>';
$html .= 'Um abraço do nosso time<br><br>';
$html .= 'TITI Cuidadores Cuidadosos<br>';
$html .= 'www.titicuidadores.com.br<br><br>';
$html .= 'Curta nossa página no Facebook: https://www.facebook.com/TITICuidadores/<br>';

$text = 'Olá, '.$nome.', tudo bem? /n/n' . $html;
$text = str_replace("<br>", '/n', $text);
$mail_titi = str_replace("[texto]", $html, $mail_titi);
$mail_titi = str_replace("[nome]", $nome, $mail_titi);

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
    var_export($e);
}
?>
