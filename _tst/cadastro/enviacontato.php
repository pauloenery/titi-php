<?php
$data = array(
    "nome" => "Paulo Nery", 
    "email" => "paulo.nery@uol.com.br", 
    "mensagem" => "bla bla bla", 
    "telefone" => "999999999", 
    "tipocontato" => "telefone");
$data_string = json_encode($data);                                                                                   

//$ch = curl_init('http://localhost/titi-php/_tst/cadastro/contato.php');
$ch = curl_init('http://titicuidadores.com.br/_prd/cadastro/contato.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);                                                                                                                   

$result = curl_exec($ch);
?>