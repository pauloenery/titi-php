<?php
set_time_limit(3600);
ignore_user_abort(true);

include "../phpfunction/header_1.php";
include "../phpfunction/userfunction.php";

$cep = $_GET ["cep"];
$atuacao = $_GET ["atuacao"];
$pacientesID = $_GET ["pacientesID"];

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
            usuarios.tel,
            usuarios.cel,
            usuarios.email,
            usuarios.latitude,
            usuarios.longitude,
            especialistas.especialistasID,
            especialistas.orgaoemissor,
            especialistas.nr_identificacao,
            especialistas.atuacao,
            especialistas.periodo,
            especialistas.perfilespecialista,
            especialistas.habilidade,
            especialistas.experiencia,            
            especialistas.minicv,            
            especialistas.classificacao,
            especialistas.total
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
        . "longitude BETWEEN  '$longitude1' and '$longitude2' "
        . "ORDER BY especialistas.classificacao DESC , especialistas.total DESC";

$sql = mysql_query($queryprofissional, $db) or die($queryprofissional . "<br/><br/>" . mysql_error());
$retorno = array();
$locations = array();
$i = 0;

if ($i == 0) {
    $pacientes_pesquisaID = historico($pacientesID, $cep, $atuacao);
}

while ($dados = mysql_fetch_array($sql)) {

    $retorno[$i]["nome"] = $dados["nome"];
    $retorno[$i]["latitude"] = $dados["latitude"];
    $retorno[$i]["longitude"] = $dados["longitude"];
    $retorno[$i]["foto"] = $dados["foto"];
    $retorno[$i]["tel"] = $dados["tel"];
    $retorno[$i]["cel"] = $dados["cel"];
    $retorno[$i]["email"] = $dados["email"];
    $retorno[$i]["especialistasID"] = $dados["especialistasID"];
    $retorno[$i]["cargo"] = cargo($dados["atuacao"]);
    $retorno[$i]["periodo"] = periodo($dados["periodo"]);
    $retorno[$i]["perfilespecialista"] = perfilespecialista($dados["perfilespecialista"]);
    $retorno[$i]["habilidade"] = habilidade($dados["habilidade"]);
    $retorno[$i]["experiencia"] = $dados["experiencia"];
    $retorno[$i]["minicv"] = $dados["minicv"];
    $retorno[$i]["classificacao"] = $dados["classificacao"];
    $retorno[$i]["total"] = $dados["total"];

    historico_item($pacientes_pesquisaID, $dados["especialistasID"]);

    $i++;
}
$retorno[$i]["nome"] = "Meu Local";
$retorno[$i]["latitude"] = "$latitude";
$retorno[$i]["longitude"] = "$longitude";

if (!($i == 0)) {
    $emailpaciente = emailpaciente($pacientesID);
    $nome = $emailpaciente[0];
    $email = $emailpaciente[1];
    include '../SendGrid/BuscaCompleta.php';
}

//var_dump($retorno) . '</br>';
$json_retorno = json_encode($retorno);
echo $json_retorno;
//echo $json_locations;

function historico($pacientesID, $cep, $atuacao) {
    include "../phpfunction/configuracao.php";
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);
    $query = "INSERT INTO `pacientes_pesquisa` (pacientesID, cep, atuacao) VALUES ($pacientesID, '$cep', '$atuacao')";
    $sqlhist = mysql_query($query, $db) or die($query . "<br/><br/>" . mysql_error());
    $last_inserted = mysql_insert_id();
    return $last_inserted;
}

function historico_item($pacientes_pesquisaID, $especialistasID) {
    include "../phpfunction/configuracao.php";
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);
    $query = "INSERT INTO `pacientes_pesquisa_item` (pacientes_pesquisaID, especialistasID) VALUES ($pacientes_pesquisaID, $especialistasID)";
    $sqlhist = mysql_query($query, $db) or die($query . "<br/><br/>" . mysql_error());
}

function emailpaciente($pacientesID) {
    include "../phpfunction/configuracao.php";
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);
    $query = "SELECT nome,email  FROM `pacientes` INNER JOIN usuarios ON pacientes.usuariosID=usuarios.usuariosID where pacientesID = $pacientesID";
    $sqlemail = mysql_query($query, $db) or die($query . "<br/><br/>" . mysql_error());
    while ($linha = mysql_fetch_array($sqlemail)) {
        $email = $linha["email"];
        $nome = $linha["nome"];
    }
    return [$nome, $email];
}
?>
