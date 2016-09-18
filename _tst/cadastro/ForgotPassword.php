<?php

include "../phpfunction/header_1.php";

include "../phpfunction/configuracao.php";

$email = $_GET ["email"];

$tabela = "usuarios";     //o nome de sua tabela

$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

//$entityBody = file_get_contents('php://input');

//$arrayBody = json_decode($entityBody, TRUE);

$i = 0;

/*
if (is_null($arrayBody)) {
    $email = $_REQUEST ["email"];
} else {
    $email = (isset($arrayBody [$i] ["email"]) ? $arrayBody [$i] ["email"] : "");
}
*/
$nome = '';
$senha = '';
$email = strtolower($email);
$email = str_replace(" ", "", $email);
//echo "email: " . $email;

$query = "SELECT 
            nome 
        FROM `$tabela` 
        WHERE email='$email' ";

$resultado = mysql_query($query, $db) or print mysql_error();
$contagem = mysql_num_rows($resultado);
$retorno = array();
$i = 0;

while ($linha = mysql_fetch_array($resultado)) {
    $nome = $linha["nome"];
    http_response_code(200);
}

if ($contagem == 0) {
    $retorno[$i]["status"] = "ERR";
    $retorno[$i]["mensagem"] = "e-mail não cadastrado";
    http_response_code(400);
} else {
    $senha = GeraHash(8);

    $queryupdate = "UPDATE $tabela SET "
            . "`senha` = AES_ENCRYPT('$senha','password')"
            . " WHERE email = '$email'";

    $cadastrar = mysql_query($queryupdate, $db);

    if ($cadastrar == 1) {
        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Senha alterada com sucesso";
        include '../SendGrid/ForgotPassword.php';
        http_response_code(200);
    }
}

//echo "nome: " . $nome . " - senha: " . $senha;
//var_dump($retorno) . '</br>';
$json_retorno = json_encode($retorno);
//var_dump($json_retorno) . '</br>';
http_response_code();
echo $json_retorno;

function GeraHash($qtd) {
//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
    $Caracteres = 'abcdefghijklmnopqrstuvxwyz1234567890ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
    $QuantidadeCaracteres = strlen($Caracteres);
    $QuantidadeCaracteres--;

    $Hash = NULL;
    for ($x = 1; $x <= $qtd; $x++) {
        $Posicao = rand(0, $QuantidadeCaracteres);
        $Hash .= substr($Caracteres, $Posicao, 1);
    }

    return $Hash;
}

?>