<?php

include "../phpfunction/header_1.php";
include "../phpfunction/userfunction.php";

$cep = $_GET ["cep"];
$atuacao = $_GET ["atuacao"];

$address = urlencode($cep);

$url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

$resp_json = file_get_contents_curl($url);
$resp = json_decode($resp_json, true);

if ($resp['status'] == 'OK'):
    $i = 0;
    foreach ($resp["results"] as $key) {

        $latitude = $resp['results'][$i]['geometry']['location']['lat'];
        $longitude = $resp['results'][$i]['geometry']['location']['lng'];

        $i++;
    }
endif;

include "../phpfunction/configuracao.php";

$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$latitude1 = (double) $latitude + 0.0665;
$latitude2 = (double) $latitude - 0.0665;
$longitude1 = (double) $longitude + 0.0665;
$longitude2 = (double) $longitude - 0.0665;

$queryprofissional = "SELECT 
            usuarios.foto,
            usuarios.nome,
            especialistas.atuacao,
            especialistas.classificacao
                FROM especialistas 
                INNER JOIN usuarios
                ON especialistas.usuariosID=usuarios.usuariosID
                where perfilID=2 and "
        . "disponibilidade=1 and "
        . "ativo=1 and ";
If ($atuacao != 0) {
    $queryprofissional .= "atuacao=$atuacao and ";
}
$queryprofissional .= "latitude  BETWEEN  '$latitude1' and '$latitude2' and "
        . "longitude BETWEEN  '$longitude1' and '$longitude2'";

$sql = mysql_query($queryprofissional, $db) or die($queryprofissional . "<br/><br/>" . mysql_error());
//$aux = mysql_fetch_array($sql);
$retorno = array();
$i = 0;
while ($dados = mysql_fetch_array($sql)) {

    $retorno[$i]["foto"] = $dados["foto"];
    $retorno[$i]["nome"] = nome($dados["nome"]);
    $retorno[$i]["cargo"] = cargo($dados["atuacao"]);
    $retorno[$i]["classificacao"] = $dados["classificacao"];

    $i++;
}

//var_dump($retorno) . '</br>';
$json_retorno = json_encode($retorno);
//var_dump($json_retorno) . '</br>';
echo $json_retorno;

?>