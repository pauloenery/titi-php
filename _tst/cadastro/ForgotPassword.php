<?php

include "../phpfunction/header_1.php";

include "../phpfunction/configuracao.php";
$tabela = "usuarios";     //o nome de sua tabela
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$entityBody = file_get_contents('php://input');
//$entityBody = file_get_contents('./ressetpass.txt', true);
$arrayBody = [json_decode($entityBody, TRUE)];
//var_dump($arrayBody);
$i = 0;

if (is_null($arrayBody)) {
    $email = $_REQUEST ["email"];
} else {
    $email = (isset($arrayBody [$i] ["email"]) ? $arrayBody [$i] ["email"] : "");
}

$return_usuario = update_usuario($email);
$msg_usuario = $return_usuario[0];
if ($msg_usuario["status"] == "OK") {
    http_response_code(200);
} else {
    http_response_code(400);
}
if (count($return_usuario) > 0) {
    $retorno[$i]["status"] = $return_usuario[0]["status"];
    $retorno[$i]["mensagem"] = $return_usuario[0]["mensagem"];
    $i++;
}

//var_dump($retorno) . '</br>';
$json_retorno = json_encode($retorno);
//var_dump($json_retorno) . '</br>';
http_response_code();
echo $json_retorno;

function update_usuario($email) {
    include "../phpfunction/configuracao.php";
    $tabela = "usuarios";     //o nome de sua tabela
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);
    
    $senha = GeraHash(8);
    
    $queryupdate = "UPDATE $tabela SET "
            . "`senha` = AES_ENCRYPT('$senha','password')"
            . " WHERE email = $email";

    $cadastrar = mysql_query($queryupdate, $db);
    $retorno = array();

    $i = 0;
    if ($cadastrar == 1) {
        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Senha alterada com sucesso";
        $retorno[$i]["senha"] = $senha;
    } else {
        $retorno[$i]["status"] = "ERR";
        $retorno[$i]["mensagem"] = "Usuário não cadastrado";
    }
    return $retorno;
}

function GeraHash($qtd){ 
//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
$Caracteres = 'abcdefghijklmnopqrstuvxwyz1234567890ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789'; 
$QuantidadeCaracteres = strlen($Caracteres); 
$QuantidadeCaracteres--; 

$Hash=NULL; 
    for($x=1;$x<=$qtd;$x++){ 
        $Posicao = rand(0,$QuantidadeCaracteres); 
        $Hash .= substr($Caracteres,$Posicao,1); 
    } 

return $Hash; 
} 

?>