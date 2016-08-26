<?php

include "../phpfunction/header_1.php";

include "../phpfunction/configuracao.php";
$tabela = "usuarios";     //o nome de sua tabela
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$entityBody = file_get_contents('php://input');
//$entityBody = file_get_contents('./pass.txt', true);
$arrayBody = [json_decode($entityBody, TRUE)];
//var_dump($arrayBody);
$i = 0;

if (is_null($arrayBody)) {
    $usuariosID = $_REQUEST ["usuariosID"];
    $senha = $_REQUEST ["senha"];
} else {
    $usuariosID = (isset($arrayBody [$i] ["usuariosID"]) ? $arrayBody [$i] ["usuariosID"] : "");
    $senha = (isset($arrayBody [$i] ["senha"]) ? $arrayBody [$i] ["senha"] : "");
}

$return_usuario = update_usuario($usuariosID, $senha);
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

function update_usuario($usuariosID, $senha) {
    include "../phpfunction/configuracao.php";
    $tabela = "usuarios";     //o nome de sua tabela
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);

    $queryupdate = "UPDATE $tabela SET "
            . "`senha` = AES_ENCRYPT('$senha','password')"
            . " WHERE usuariosID = $usuariosID";

    $cadastrar = mysql_query($queryupdate, $db);
    $retorno = array();

    $i = 0;
    if ($cadastrar == 1) {
        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Usuário Alterado com sucesso";
    } else {
        $retorno[$i]["status"] = "ERR";
        $retorno[$i]["mensagem"] = "Usuário não Alterado";
    }
    return $retorno;
}

?>