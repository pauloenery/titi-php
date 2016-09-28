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
    setFrom( "noreplay@titi.net.br" )->
    addTo( "contato@titi.net.br" )->
    setSubject( "Contato" )->
    setText( "Seu Nome: $nome, \n\n"
            . "E-mail: $email \n\n"
            . "Mensagem: $mensagem \n\n" )->
    setHtml( "<table style=\"border: solid 1px #000; background-color: #ccc; font-family: verdana, tahoma, sans-serif; color: #000;\"> "
            . "<tr>"
            . "<td> "
            . "<h2>Seu Nome: $nome,</h2> <br>"
            . "<p>"
            . "E-mail: $email <br><br>"
            . "Mensagem: $mensagem  <br><br>"
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
