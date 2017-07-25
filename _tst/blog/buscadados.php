<?php
ob_start();
include "../phpfunction/geralog.php";
include "../phpfunction/configuracao.php";
include "../phpfunction/userfunction.php";

$tabela = "usuarios";     //o nome de sua tabela

$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$entityBody = file_get_contents('php://input'); //$entityBody = '{"email":"paulo.nery@uol.com.br","senha":"1234","perfilID":"3"}';

$arrayBody = json_decode($entityBody, TRUE);
$i = 0;

if (is_null($arrayBody)) {
    $email = $_REQUEST ["email"];
} else {
    $email = $arrayBody ["email"];
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
    minicv,
    classificacao,
    total,
    disponibilidade, 
    ativo       
FROM 
    usuarios
LEFT JOIN 
    especialistas ON usuarios.usuariosID = especialistas.usuariosID
WHERE 
    usuarios.email = '$email'";

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
    $retorno[$i]["especialistasID"] = $linha["especialistasID"];
    $retorno[$i]["orgaoemissor"] = orgaoemissor($linha["orgaoemissor"]);
    $retorno[$i]["nr_identificacao"] = $linha["nr_identificacao"];
    $retorno[$i]["registro"] = $linha["registro"];
    $retorno[$i]["UF"] = $linha["UF"];
    $retorno[$i]["atuacao"] = cargo($linha["atuacao"]);
    $retorno[$i]["periodo"] = periodo($linha["periodo"]);
    $retorno[$i]["perfilespecialista"] = perfilespecialista($linha["perfilespecialista"]);
    $retorno[$i]["habilidade"] = habilidade($linha["habilidade"]);
    $retorno[$i]["experiencia"] = $linha["experiencia"];
    $retorno[$i]["minicv"] = $linha["minicv"];
    $retorno[$i]["classificacao"] = $linha["classificacao"];
    $retorno[$i]["total"] = $linha["total"];
    $retorno[$i]["disponibilidade"] = disponibilidade($linha["disponibilidade"]);
}
if ($contagem == 0) {
    $retorno[$i]["mensagem"] = "Usuário não encontrado";
}

$especialistasID = $retorno[$i]["especialistasID"];
$query_class = "
SELECT 
    especialistas_classificacaoID, 
    especialistasID,
    usuarios.nome,
    especialistas_classificacao.pacientesID, 
    especialistas_classificacao.classificacao,
    comentario,
    especialistas_classificacao.data
FROM especialistas_classificacao
LEFT JOIN 
    pacientes ON pacientes.pacientesID = especialistas_classificacao.pacientesID
LEFT JOIN 
    usuarios ON usuarios.usuariosID = pacientes.usuariosID
WHERE 
    especialistasID = $especialistasID";

$resultado = mysql_query($query_class, $db) or print mysql_error();
$contagemclass = mysql_num_rows($resultado);
$retornoclass = array();
$c=0;
while ($linha = mysql_fetch_array($resultado)) {
    $retornoclass[$c]["especialistas_classificacaoID"] = $linha["especialistas_classificacaoID"];
    $retornoclass[$c]["especialistasID"] = $linha["especialistasID"];
    $retornoclass[$c]["pacientesID"] = $linha["pacientesID"];
    $retornoclass[$c]["nome"] = nome($linha["nome"]);
    $retornoclass[$c]["classificacao"] = $linha["classificacao"];
    $retornoclass[$c]["comentario"] = $linha["comentario"];
    $retornoclass[$c]["data"] = $linha["data"];
    $c=$c+1;
}
if ($contagemclass == 0) {
    $retornoclass[$c]["mensagem"] = "Não Existem Classificações";
}

$json_retorno = json_encode($retornoclass);


function nascimento($nascimento) {
    if ($nascimento == '') {
        return $nascimento;
    } else {
        $date = DateTime::createFromFormat('d/m/Y', $nascimento);
        //$nascimento = $date->format('Y-m-d');
        $nascimento = $date->format(DATE_W3C);
        return substr($nascimento, 0,10);
    }
}
function orgaoemissor($orgaoemissor) {
    if ($orgaoemissor == 'OUTRO') {
        return "CUIDADOR";
    } else {
        return $orgaoemissor;
    }
}
function disponibilidade($disponibilidade) {
    if ($disponibilidade == '1') {
        return "Sim";
    } else {
        return "Não";
    }
}

?>
