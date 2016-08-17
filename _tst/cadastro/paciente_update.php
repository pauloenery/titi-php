<?php

include "../phpfunction/header_1.php";

include "../phpfunction/configuracao.php";
$tabela = "usuarios";     //o nome de sua tabela
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$entityBody = file_get_contents('php://input');
//$entityBody = file_get_contents('./paciente.txt', true);
//var_dump($entityBody);
$arrayBody = [json_decode($entityBody, TRUE)];
//var_dump($arrayBody);
$i = 0;

if (is_null($arrayBody)) {
    $usuariosID = $_REQUEST ["usuariosID"];
    $perfilID = $_REQUEST ["perfilID"];
    $nome = $_REQUEST ["nome"];
    $nascimento = $_REQUEST ["nascimento"];
    $sexo = $_REQUEST ["sexo"];
    $tel = $_REQUEST ["tel"];
    $cel = $_REQUEST ["cel"];
    $email = $_REQUEST ["email"];
    $foto = $_REQUEST ["foto"];
    $cpf_cnpj = $_REQUEST ["cpf_cnpj"];
    $rg = $_REQUEST ["rg"];
    $endereco = $_REQUEST ["endereco"];
    $bairro = $_REQUEST ["bairro"];
    $cep = $_REQUEST ["cep"];
    $cidade = $_REQUEST ["cidade"];
    $estado = $_REQUEST ["estado"];
    $senha = $_REQUEST ["senha"];
    $termos = $_REQUEST ["termos"];
} else {
    $usuariosID = (isset($arrayBody [$i] ["usuariosID"]) ? $arrayBody [$i] ["usuariosID"] : "");
    $perfilID = (isset($arrayBody [$i] ["perfilID"]) ? $arrayBody [$i] ["perfilID"] : "");
    $nome = (isset($arrayBody [$i] ["nome"]) ? $arrayBody [$i] ["nome"] : "");
    $nascimento = (isset($arrayBody [$i] ["nascimento"]) ? $arrayBody [$i] ["nascimento"] : "");
    $sexo = (isset($arrayBody [$i] ["sexo"]) ? $arrayBody [$i] ["sexo"] : "");
    $tel = (isset($arrayBody [$i] ["tel"]) ? $arrayBody [$i] ["tel"] : "");
    $cel = (isset($arrayBody [$i] ["cel"]) ? $arrayBody [$i] ["cel"] : "");
    $email = (isset($arrayBody [$i] ["email"]) ? $arrayBody [$i] ["email"] : "");
    $foto = (isset($arrayBody [$i] ["foto"]) ? $arrayBody [$i] ["foto"] : "");
    $cpf_cnpj = (isset($arrayBody [$i] ["cpf_cnpj"]) ? $arrayBody [$i] ["cpf_cnpj"] : "");
    $rg = (isset($arrayBody [$i] ["rg"]) ? $arrayBody [$i] ["rg"] : "");
    $endereco = (isset($arrayBody [$i] ["endereco"]) ? $arrayBody [$i] ["endereco"] : "");
    $bairro = (isset($arrayBody [$i] ["bairro"]) ? $arrayBody [$i] ["bairro"] : "");
    $cep = (isset($arrayBody [$i] ["cep"]) ? $arrayBody [$i] ["cep"] : "");
    $cidade = (isset($arrayBody [$i] ["cidade"]) ? $arrayBody [$i] ["cidade"] : "");
    $estado = (isset($arrayBody [$i] ["estado"]) ? $arrayBody [$i] ["estado"] : "");
    $senha = (isset($arrayBody [$i] ["senha"]) ? $arrayBody [$i] ["senha"] : "");
    $termos = (isset($arrayBody [$i] ["termos"]) ? $arrayBody [$i] ["termos"] : "");
    $nascimento = date('d/m/Y', strtotime($nascimento));
    $pacientesID = (isset($arrayBody [$i] ["pacientesID"]) ? $arrayBody [$i] ["pacientesID"] : "");
}

$retorno = array();
$return_usuario = array();
$return_paciente = array();

if (isset($email)) {

    if ($usuariosID == "") { //novo_usuario
        $query = "SELECT email FROM $tabela WHERE email = '$email'";
        $pesquisar = mysql_query($query, $db);
        $contagem = mysql_num_rows($pesquisar);

        if ($contagem == 1) {
            $retorno[$i]["status"] = "ERRO";
            $retorno[$i]["mensagem"] = "O email que você escolheu já está cadastrado.";
            $i++;
        }
        if ($i > 0) {
            http_response_code(400);
        } else {
            $return_usuario = novo_usuario($perfilID, $nome, $nascimento, $sexo, $tel, $cel, $email, $foto, $cpf_cnpj, $rg, $endereco, $bairro, $cep, $cidade, $estado, $senha, $termos);
            //var_dump($return_usuario);
            $msg_usuario = $return_usuario[0];
            if ($msg_usuario["status"] == "OK") {
                $usuariosID = $return_usuario[1]["usuariosID"];
                $return_paciente = novo_paciente($usuariosID);
                // testar retorno especialista
                http_response_code(200);
            } else {
                //
                http_response_code(400);
            }
        }
    } else {
        $return_usuario = update_usuario($usuariosID, $perfilID, $nome, $nascimento, $sexo, $tel, $cel, $foto, $cpf_cnpj, $rg, $endereco, $bairro, $cep, $cidade, $estado, $senha, $termos);
        $msg_usuario = $return_usuario[0];
        if ($msg_usuario["status"] == "OK") {
            if ($pacientesID == "") { //novo_paciente
                $return_paciente = novo_paciente($usuariosID);
                // testar retorno especialista
                http_response_code(200);
            } else {
                //$return_paciente = update_especialista($usuariosID, $pacientesID);
                // testar retorno especialista
                http_response_code(200);
            }
        } else {
            http_response_code(400);
        }
    }
    if (count($return_usuario) > 0) {
        $retorno[$i]["status"] = $return_usuario[0]["status"];
        $retorno[$i]["mensagem"] = $return_usuario[0]["mensagem"];
        $i++;
    }
}



//var_dump($retorno) . '</br>';
$json_retorno = json_encode($retorno);
//var_dump($json_retorno) . '</br>';
http_response_code();
echo $json_retorno;

function novo_usuario($perfilID, $nome, $nascimento, $sexo, $tel, $cel, $email, $foto, $cpf_cnpj, $rg, $endereco, $bairro, $cep, $cidade, $estado, $senha, $termos) {
    include "../phpfunction/configuracao.php";
    $tabela = "usuarios";     //o nome de sua tabela
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);

    $localizacao = geo_address($endereco, $bairro, $cep, $cidade, $estado);
    $latitude = $localizacao[0];
    $longitude = $localizacao[1];

    $nome_imagem = "";
    //$nome_imagem = upload_foto();

    $querynovousuario = "INSERT INTO `$tabela` (nome, nascimento, sexo, tel, cel, email, cpf_cnpj, rg, endereco, bairro, cep, cidade, estado, latitude, longitude, senha, perfilID, foto, termos)
                                        VALUES ('$nome','$nascimento','$sexo','$tel','$cel','$email','$cpf_cnpj','$rg','$endereco','$bairro','$cep','$cidade','$estado','$latitude','$longitude',AES_ENCRYPT('$senha','password'),$perfilID,'$nome_imagem','$termos')";
    $cadastrar = mysql_query($querynovousuario, $db);
    $sqlerro = mysql_errno($db) . ':' . mysql_error($db) . '\\n';

    $retorno = array();
    $i = 0;
    if ($cadastrar == 1) {
        $query = "SELECT usuariosID FROM $tabela WHERE email = '$email'";
        $resultado = mysql_query($query, $db) or print mysql_error();
        $contagem = mysql_num_rows($resultado);

        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Usuário incluido com sucesso";
        while ($linha = mysql_fetch_array($resultado)) {
            $i++;
            $retorno[$i]["usuariosID"] = $linha["usuariosID"];
        }
    } else {
        $retorno[$i]["status"] = "ERRO";
        $retorno[$i]["mensagem"] = "Usuário não incluido";
    }
    return $retorno;
}

function update_usuario($usuariosID, $perfilID, $nome, $nascimento, $sexo, $tel, $cel, $foto, $cpf_cnpj, $rg, $endereco, $bairro, $cep, $cidade, $estado, $senha, $termos) {
    include "../phpfunction/configuracao.php";
    $tabela = "usuarios";     //o nome de sua tabela
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);

    $localizacao = geo_address($endereco, $bairro, $cep, $cidade, $estado);
    $latitude = $localizacao [0];
    $longitude = $localizacao [1];

    $queryupdate = "UPDATE $tabela SET "
            . "`nome` = '$nome' , "
            . "`nascimento` = '$nascimento' , "
            . "`sexo` = '$sexo', "
            . "`tel` = '$tel' , "
            . "`cel` = '$cel' , "
            . "`cpf_cnpj` = '$cpf_cnpj' , "
            . "`rg` = '$rg' , "
            . "`endereco` = '$endereco' , "
            . "`bairro` = '$bairro' , "
            . "`cep` = '$cep' , "
            . "`cidade` = '$cidade' , "
            . "`estado` = '$estado' , "
            . "`termos` = '$termos' , "
            . "`latitude` = '$latitude ' , "
            . "`longitude` = '$longitude' , "
            . "`senha` = AES_ENCRYPT('$senha','password')"
            . " WHERE usuariosID = $usuariosID";

    $cadastrar = mysql_query($queryupdate, $db);
    $retorno = array();

    $i = 0;
    if ($cadastrar == 1) {
        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Usuário Alterado com sucesso";
    } else {
        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Usuário não Alterado";
    }
    return $retorno;
}
function novo_paciente($usuariosID) {
    include "../phpfunction/configuracao.php";
    $tabela = "pacientes";     //o nome de sua tabela
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);
    $pesquisar = mysql_query("SELECT * FROM $tabela WHERE usuariosID = '$usuariosID'", $db);
    $contagem = mysql_num_rows($pesquisar);
    $retorno = array();
    $i = 0;

    if ($contagem == 1) {
        $retorno[$i]["status"] = "ERRO";
        $retorno[$i]["mensagem"] = "Paciente já cadastrado";
        $i++;
    }

    if ($i == 0) {
        $querynovousuario = "INSERT INTO `$tabela` (usuariosID)
                                        VALUES ($usuariosID)";

        $cadastrar = mysql_query($querynovousuario, $db);

        if ($cadastrar == 1) {
            $retorno[$i]["status"] = "OK";
            $retorno[$i]["mensagem"] = "Paciente incluido com sucesso";
            $i++;
        } else {
            $retorno[$i]["status"] = "ERRO";
            $retorno[$i]["mensagem"] = "Paciente não incluido";
            $i++;
        }
    }
    return $retorno;
}

function update_paciente($usuariosID, $pacientesID) {
    include "../phpfunction/configuracao.php";
    $tabela = "pacientes";     //o nome de sua tabela

    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);

    $queryupdate = "UPDATE $tabela SET "
            . "`disponibilidade` = '$disponibilidade'  WHERE pacientesID = $pacientesID";

    $cadastrar = mysql_query($queryupdate, $db);
    $retorno = array();
    $i = 0;

    if ($cadastrar == 1) {
        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Paciente Alterado com sucesso";
        $i++;
    } else {
        $retorno[$i]["status"] = "ERRO";
        $retorno[$i]["mensagem"] = "Paciente não Alterado";
        $i++;
    }
    return $retorno;
}

function geo_address($endereco, $bairro, $cep, $cidade, $estado) {
    $address = urlencode($endereco . ', ' . $bairro . ', ' . $cep . ', ' . $cidade . ', ' . $estado);

    $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

    $resp_json = file_get_contents($url);
    $resp = json_decode($resp_json, true);

    $latitude = '';
    $longitude = '';

    if ($resp['status'] == 'OK'):

        $i = 0;

        $latitude = $resp['results'][$i]['geometry']['location']['lat'];
        $longitude = $resp['results'][$i]['geometry']['location']['lng'];


    endif;
    return array($latitude, $longitude);
}
