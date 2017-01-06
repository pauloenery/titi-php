<?php
set_time_limit( 3600 ); 
ignore_user_abort( true ); 

include "../phpfunction/header_1.php";
include "../phpfunction/geralog.php";
include "../phpfunction/configuracao.php";

$tabela = "contato";     //o nome de sua tabela

$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$entityBody = file_get_contents('php://input');
//$entityBody = file_get_contents('./contato.json', true);
//var_dump($entityBody);

$arrayBody = json_decode($entityBody, TRUE);
//var_dump($arrayBody);

geralog($entityBody,$_SERVER["PHP_SELF"]);

$nome = "";
$email = "";
$mensagem = "";

$i = 0;

if (is_null($arrayBody)) {
    $nome = $_REQUEST ["nome"];
    $email = $_REQUEST ["email"];
    $mensagem = $_REQUEST ["mensagem"];
} else {
    $nome = (isset($arrayBody ["nome"]) ? $arrayBody ["nome"] : "");
    $email = (isset($arrayBody ["email"]) ? $arrayBody ["email"] : "");
    $mensagem = (isset($arrayBody ["mensagem"]) ? $arrayBody ["mensagem"] : "");
}

$email = strtolower($email);
$email = str_replace(" ", "", $email);


if ($email == "" or $nome == "" or $mensagem == "") {
    http_response_code(400);
} else {

    $querynovocontato = "INSERT INTO `$tabela` (nome, email, mensagem)
                                    VALUES ('$nome','$email','$mensagem')";

    $resultado = mysql_query($querynovocontato, $db) or print mysql_error();

    include '../SendGrid/contato.php';

    http_response_code(200);
}
http_response_code();
?>