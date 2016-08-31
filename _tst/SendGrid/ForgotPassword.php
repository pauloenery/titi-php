<?php

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


/* USER CREDENTIALS
/  Fill in the variables below with your SendGrid
/  username and password.
====================================================*/
$sg_username = "paulo.nery";
$sg_password = "1q2w3e4r5t";


/* CREATE THE SENDGRID MAIL OBJECT
====================================================*/
$sendgrid = new SendGrid( $sg_username, $sg_password );
$mail = new SendGrid\Email();




/* SEND MAIL
/  Replace the the address(es) in the setTo/setTos
/  function with the address(es) you're sending to.
====================================================*/
try {
    $mail->
    setFrom( "titi@titi.net.br" )->
    addTo( $email )->
    setSubject( "Recuperar de senha" )->
    setText( "Caro(a) $nome, \n\n"
            . "Atendendo a um pedido feito em seu nome, estamos enviando a \n"
            . "senha de acesso à TITI cadastrada para esse e-mail. \n\n"
            . "Se você não fez esse pedido ou não é cadastrado ao TITI,\n"
            . "entre em contato pelo e-mail\n"
            . "contato@titi.net.br\n\n"
            . "Informações de acesso:\n\n"
            . "E-mail: $email \n"
            . "Senha: $senha \n\n"
            . "Obrigado e continue com a gente\n\n"
            . "Equipe TITI\n"
            . "http://www.titi.net.br" )->
    setHtml( "<table style=\"border: solid 1px #000; background-color: #ccc; font-family: verdana, tahoma, sans-serif; color: #000;\"> "
            . "<tr>"
            . "<td> "
            . "<h2>Caro(a) $nome,</h2> <br>"
            . "<p>"
            . "Atendendo a um pedido feito em seu nome, estamos enviando a <br>"
            . "senha de acesso à TITI cadastrada para esse e-mail. <br><br>"
            . "Se você não fez esse pedido ou não é cadastrado ao TITI,<br>"
            . "entre em contato pelo e-mail<br>"
            . "contato@titi.net.br <br><br>"
            . "Informações de acesso:<br><br>"
            . "E-mail: $email <br>"
            . "Senha: $senha  <br><br>"
            . "Obrigado e continue com a gente<br><br>"
            . "Equipe TITI <br>"
            . "http://www.titi.net.br<br>"
            . "</p>"
            . "</td>"
            . "</tr> "
            . "</table>" );
    
    $response = $sendgrid->send( $mail );
    
    /*
    if (!$response) {
        throw new Exception("Did not receive response.");
    } else if ($response->message && $response->message == "error") {
        throw new Exception("Received error: ".join(", ", $response->errors));
    } else {
        print_r($response);
    }
     */
    
} catch ( Exception $e ) {
    var_export($e);
}


?>
