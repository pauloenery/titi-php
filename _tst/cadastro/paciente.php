<?php

include "../phpfunction/header_1.php";

include "../phpfunction/configuracao.php";
//$tabela = "especialistas";     //o nome de sua tabela
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$entityBody = file_get_contents('php://input');
//$entityBody = '{"usuariosID":"11"}';
//var_dump($entityBody);
$arrayBody = [json_decode($entityBody, TRUE)];
//var_dump($arrayBody);


$i = 0;

if (is_null($arrayBody)) {
    $usuariosID = $_REQUEST ["usuariosID"];
} else {
    $usuariosID = (isset($arrayBody [$i] ["usuariosID"]) ? $arrayBody [$i] ["usuariosID"] : "0");
}



$query = "
SELECT
    usuarios.usuariosID, 
    perfilID, 
    nome, 
    nascimento, 
    sexo, 
    tel, 
    cel, 
    email, 
    foto, 
    cpf_cnpj, 
    rg, 
    endereco, 
    bairro, 
    cep, 
    cidade, 
    estado, 
    AES_DECRYPT(senha,'password') AS senha , 
    termos,
    pacientesID
FROM 
    usuarios
LEFT JOIN 
    pacientes ON usuarios.usuariosID = pacientes.usuariosID
WHERE 
    usuarios.usuariosID = $usuariosID";

$resultado = mysql_query($query, $db) or print mysql_error();
$contagem = mysql_num_rows($resultado);
$retorno = array();

while ($linha = mysql_fetch_array($resultado)) {
    $retorno[$i]["usuariosID"] = $linha["usuariosID"];
    $retorno[$i]["perfilID"] = $linha["perfilID"];
    $retorno[$i]["nome"] = $linha["nome"];
    $retorno[$i]["nascimento"] = nascimento($linha["nascimento"]);
    $retorno[$i]["sexo"] = $linha["sexo"];
    $retorno[$i]["tel"] = $linha["tel"];
    $retorno[$i]["cel"] = $linha["cel"];
    $retorno[$i]["email"] = $linha["email"];
    $retorno[$i]["foto"] = $linha["foto"];
    $retorno[$i]["cpf_cnpj"] = $linha["cpf_cnpj"];
    $retorno[$i]["rg"] = $linha["rg"];
    $retorno[$i]["endereco"] = $linha["endereco"];
    $retorno[$i]["bairro"] = $linha["bairro"];
    $retorno[$i]["cep"] = $linha["cep"];
    $retorno[$i]["cidade"] = $linha["cidade"];
    $retorno[$i]["estado"] = $linha["estado"];
    $retorno[$i]["senha"] = $linha["senha"];
    $retorno[$i]["termos"] = $linha["termos"];
    $retorno[$i]["pacientesID"] = $linha["pacientesID"];
    http_response_code(200);
}
if ($contagem == 0) {
    $retorno[$i]["mensagem"] = "Usuário não encontrado";
    http_response_code(400);
}
//var_dump($retorno) . '</br>';
$json_retorno = json_encode($retorno);
//var_dump($json_retorno) . '</br>';
http_response_code();
echo $json_retorno;

function nascimento($nascimento) {
    $date = DateTime::createFromFormat('d/m/Y', $nascimento);

    //$nascimento = $date->format('Y-m-d');
    $nascimento = $date->format(DATE_W3C);
    return $nascimento;
}

?>
