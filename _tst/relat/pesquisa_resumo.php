<?php

include "../phpfunction/header_1.php";

$cep = $_GET ["cep"];
$atuacao = $_GET ["atuacao"];

$address = urlencode($cep);

$url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

$resp_json = file_get_contents($url);
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
            especialistas.experiencia,
            especialistas.classificacao
                FROM especialistas 
                INNER JOIN usuarios
                ON especialistas.usuariosID=usuarios.usuariosID
                where perfilID=2 and "
        . "disponibilidade=1 and "
        . "ativo=1 and "
        . "atuacao=$atuacao and "
        . "latitude  BETWEEN  '$latitude1' and '$latitude2' and "
        . "longitude BETWEEN  '$longitude1' and '$longitude2'";

$sql = mysql_query($queryprofissional, $db) or die($queryprofissional . "<br/><br/>" . mysql_error());
$aux = mysql_fetch_array($sql);
$retorno = array();
$i = 0;
while ($dados = mysql_fetch_array($sql)) {

    $retorno[$i]["foto"] = $dados["foto"];
    $retorno[$i]["nome"] = $dados["nome"];
    $retorno[$i]["cargo"] = cargo($dados["atuacao"]);
//    $retorno[$i]["experiencia"] = $dados["experiencia"];
    $retorno[$i]["classificacao"] = $dados["classificacao"];

    $i++;
}

//var_dump($retorno) . '</br>';
$json_retorno = json_encode($retorno);
//var_dump($json_retorno) . '</br>';
echo $json_retorno;

function cargo($cargo) {

    if ($cargo == "1") {
        return 'Auxiliar/Técnico enfermagem';
    } else if ($cargo == "2") {
        return 'Enfermeiro';
    } else if ($cargo == "3") {
        return 'Cuidador';
    } else if ($cargo == "4") {
        return 'Fisioterapeuta';
    } else if ($cargo == "5") {
        return 'Fonoaudiólogo';
    } else {
        return 'Não informado';
    }
}

?>
