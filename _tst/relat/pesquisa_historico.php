<?php

include "../phpfunction/header_1.php";

$pacientesID = $_GET ["pacientesID"];

include "../phpfunction/configuracao.php";
include "../phpfunction/userfunction.php";
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$queryhistorico = "
   SELECT DISTINCT 
        pacientes.usuariosID AS p_usuariosID,
       	usuarios.usuariosID AS E_usuariosID,
       	usuarios.nome,
       	usuarios.cel,
        usuarios.tel,
        usuarios.foto,
        usuarios.email,
        pacientes.pacientesID,
	especialistas.especialistasID,
	especialistas.classificacao,
	especialistas.total,
	especialistas.atuacao,
	especialistas.periodo,
	especialistas.experiencia,
	especialistas_classificacao.classificacao as myclass,
        especialistas_classificacao.comentario
   FROM pacientes 
LEFT JOIN pacientes_pesquisa      
       ON pacientes.pacientesID=pacientes_pesquisa.pacientesID 
LEFT JOIN pacientes_pesquisa_item 
       ON pacientes_pesquisa.pacientes_pesquisaID=pacientes_pesquisa_item.pacientes_pesquisaID
LEFT JOIN especialistas 
       ON pacientes_pesquisa_item.especialistasID=especialistas.especialistasID
LEFT JOIN usuarios                
       ON especialistas.usuariosID=usuarios.usuariosID 
LEFT JOIN especialistas_classificacao 
       ON pacientes.pacientesID=especialistas_classificacao.pacientesID AND 
          especialistas.especialistasID=especialistas_classificacao.especialistasID
    where pacientes.pacientesID=$pacientesID";

$sql = mysql_query($queryhistorico, $db) or die($queryhistorico . "<br/><br/>" . mysql_error());
//$aux = mysql_fetch_array($sql);
//var_dump($aux) . '</br>';

$retorno = array();
$i = 0;

while ($dados = mysql_fetch_array($sql)) {

    $retorno[$i]["nome"] = $dados["nome"];
    $retorno[$i]["foto"] = $dados["foto"];
    $retorno[$i]["tel"] = $dados["tel"];
    $retorno[$i]["cel"] = $dados["cel"];
    $retorno[$i]["email"] = $dados["email"];
    $retorno[$i]["pacientesID"] = $dados["pacientesID"];
    $retorno[$i]["especialistasID"] = $dados["especialistasID"];
    $retorno[$i]["classificacao"] = $dados["classificacao"];
    $retorno[$i]["total"] = $dados["total"];
    $retorno[$i]["cargo"] = cargo($dados["atuacao"]);
    $retorno[$i]["periodo"] = periodo($dados["periodo"]);
    $retorno[$i]["experiencia"] = $dados["experiencia"];
    $retorno[$i]["myclass"] = $dados["myclass"];
    $retorno[$i]["comentario"] = $dados["comentario"];

    $i++;
}

//var_dump($dados) . '</br>';
$json_retorno = json_encode($retorno);
//var_dump($json_retorno) . '</br>';
echo $json_retorno;

//echo $json_locations;


?>
