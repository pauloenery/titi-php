<?php
ob_start();
include "../phpfunction/header_1.php";
include "../phpfunction/geralog.php";
include "../phpfunction/configuracao.php";

include "../phpfunction/token.php";

$tabela = "usuarios";     //o nome de sua tabela

$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$entityBody = file_get_contents('php://input');
//$entityBody = '{"email":"paulo.nery@uol.com.br","senha":"1234","perfilID":"3"}';

$arrayBody = json_decode($entityBody, TRUE);

if (is_null($arrayBody)) {
    $email = $_REQUEST ["email"];
    $senha = $_REQUEST ["senha"];
    $perfilID = $_REQUEST ["perfilID"];
} else {
    $email = $arrayBody ["email"];
    $senha = $arrayBody ["senha"];
    $perfilID = $arrayBody ["perfilID"];
}

$email = strtolower($email);
$email = str_replace(" ", "", $email);

$query = "SELECT 
            email, 
            AES_DECRYPT(senha,'password') AS senha , 
            usuarios.usuariosID, 
            nome, 
            perfilID,
            termos,
            especialistasID, 
            pacientesID 
        FROM `$tabela` 
        LEFT JOIN especialistas ON especialistas.usuariosID=usuarios.usuariosID 
        LEFT JOIN pacientes ON pacientes.usuariosID=usuarios.usuariosID 
        WHERE email='$email' AND senha=AES_ENCRYPT('$senha','password') and perfilID=$perfilID";
//echo $query;

$resultado = mysql_query($query, $db);  //or die($query) . mysql_error();
$contagem = mysql_num_rows($resultado); //or die($query) . mysql_error(); 

$retorno = array();
$errorcode = 0;
if ($contagem == 0) {
    $retorno[0]["mensagem"] = "Dados de Login inválido";
    geralog('email=' . $email, $_SERVER["PHP_SELF"]);
    geralog('senha=' . $senha, $_SERVER["PHP_SELF"]);
    $errorcode = 400;
    header('http/1.0 400 Bad Request');
} else {
    $i = 0;
    $usuariosID = '';
    while ($linha = mysql_fetch_array($resultado)) {
        $retorno[$i]["usuariosID"] = $linha["usuariosID"];
        $usuariosID = $linha["usuariosID"];
        $retorno[$i]["perfilID"] = $linha["perfilID"];
        $retorno[$i]["termos"] = $linha["termos"];
        $retorno[$i]["especialistasID"] = $linha["especialistasID"];
        $retorno[$i]["pacientesID"] = $linha["pacientesID"];
        $errorcode = 200;
}
    $token = auth($usuariosID, perfil($perfilID));
    $retorno[$i]["token"] = $token["token"];
    $retorno[$i]["userData"] = $token["userData"];
    geralog("UsuarioID:" . $usuariosID, $_SERVER["PHP_SELF"]);
}
//var_dump($retorno) . '</br>';
$json_retorno = json_encode($retorno);
//var_dump($json_retorno) . '</br>';
geralog($json_retorno, $_SERVER["PHP_SELF"]);
echo $json_retorno;
http_response_code($errorcode);
http_response_code();

function perfil($perfilID) {
    if ($perfilID == 1) {
        return "Admin";
    } elseif ($perfilID == 2) {
        return "Profissional";
    } elseif ($perfilID == 3) {
        return "Paciente";
    }
}

?>
