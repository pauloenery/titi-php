<?php

include "../phpfunction/header_1.php";

include "../phpfunction/configuracao.php";
$tabela = "usuarios";     //o nome de sua tabela
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$entityBody = file_get_contents('php://input');
//$entityBody = file_get_contents('./usuariosID.txt', true);
//$entityBody = '{"usuariosID":"1"}';
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
    especialistasID, 
    orgaoemissor, 
    nr_identificacao, 
    registro, 
    UF, 
    atuacao, 
    periodo, 
    perfilespecialista, 
    habilidade, 
    experiencia, 
    classificacao, 
    disponibilidade, 
    ativo       
FROM 
    usuarios
LEFT JOIN 
    especialistas ON usuarios.usuariosID = especialistas.usuariosID
WHERE 
    usuarios.usuariosID = $usuariosID";

$resultado = mysql_query($query, $db) or print mysql_error();
$contagem = mysql_num_rows($resultado);
$retorno = array();

while ($linha = mysql_fetch_array($resultado)) {
    $retorno[$i]["usuariosID"] = $linha["usuariosID"];
    $retorno[$i]["perfilID"] = $linha["perfilID"];
    $retorno[$i]["nome"] = $linha["nome"];
    $retorno[$i]["nascimento"] = $linha["nascimento"];
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
    $retorno[$i]["especialistasID"] = $linha["especialistasID"];
    $retorno[$i]["orgaoemissor"] = $linha["orgaoemissor"];
    $retorno[$i]["nr_identificacao"] = $linha["nr_identificacao"];
    $retorno[$i]["registro"] = $linha["registro"];
    $retorno[$i]["UF"] = $linha["UF"];
    $retorno[$i]["atuacao"] = $linha["atuacao"];
    $retorno[$i]["periodo"] = $linha["periodo"];
    $retorno[$i]["perfilespecialista"] = $linha["perfilespecialista"];
    $retorno[$i]["habilidade"] = $linha["habilidade"];
    $retorno[$i]["experiencia"] = $linha["experiencia"];
    //$retorno[$i]["classificacao"]       = $linha["classificacao"]; 
    $retorno[$i]["disponibilidade"] = $linha["disponibilidade"];
    //$retorno[$i]["ativo"]               = $linha["ativo"];
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
?>
