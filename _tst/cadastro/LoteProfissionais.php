<?php

include "../phpfunction/header_1.php";
include "../phpfunction/geralog.php";
include "../phpfunction/configuracao.php";
include "../phpfunction/userfunction.php";

$tabela = "usuarios";     //o nome de sua tabela
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

//$entityBody = file_get_contents('php://input');
//$entityBody = file_get_contents('./class.txt', true);
$entityBody = file_get_contents('./profissionais5ListaAngelica.json', true);
//var_dump($entityBody);
//geralog($entityBody, $_SERVER["PHP_SELF"]);
$arrayBody = [json_decode($entityBody, TRUE)];
//var_dump($arrayBody);
$count = count($arrayBody[0]);
$retorno = array();
$r = 0;
$perfilID = '2';
$nascimento = '';


for ($i = 0; $i < $count; $i++) {
    $nome = (isset($arrayBody [0][$i] ["nome"]) ? $arrayBody [0][$i] ["nome"] : "");
    $usuariosID = (isset($arrayBody [0][$i] ["usuariosID"]) ? $arrayBody [0][$i] ["usuariosID"] : "");
    $nome = (isset($arrayBody [0][$i] ["nome"]) ? $arrayBody [0][$i] ["nome"] : "");
    $sexo = (isset($arrayBody [0][$i] ["sexo"]) ? $arrayBody [0][$i] ["sexo"] : "");
    $tel = (isset($arrayBody [0][$i] ["tel"]) ? $arrayBody [0][$i] ["tel"] : "");
    $cel = (isset($arrayBody [0][$i] ["cel"]) ? $arrayBody [0][$i] ["cel"] : "");
    $email = (isset($arrayBody [0][$i] ["email"]) ? $arrayBody [0][$i] ["email"] : "");
    $profilePicture = (isset($arrayBody [0][$i] ["profilePicture"]) ? $arrayBody [0][$i] ["profilePicture"] : "");
    $cpf_cnpj = (isset($arrayBody [0][$i] ["cpf_cnpj"]) ? $arrayBody [0][$i] ["cpf_cnpj"] : "");
    $rg = (isset($arrayBody [0][$i] ["rg"]) ? $arrayBody [0][$i] ["rg"] : "");
    $endereco = (isset($arrayBody [0][$i] ["endereco"]) ? $arrayBody [0][$i] ["endereco"] : "");
    $bairro = (isset($arrayBody [0][$i] ["bairro"]) ? $arrayBody [0][$i] ["bairro"] : "");
    $cep = (isset($arrayBody [0][$i] ["cep"]) ? $arrayBody [0][$i] ["cep"] : "");
    $cidade = (isset($arrayBody [0][$i] ["cidade"]) ? $arrayBody [0][$i] ["cidade"] : "");
    $estado = (isset($arrayBody [0][$i] ["estado"]) ? $arrayBody [0][$i] ["estado"] : "");
    $senha = (isset($arrayBody [0][$i] ["senha"]) ? $arrayBody [0][$i] ["senha"] : "");
    $termos = (isset($arrayBody [0][$i] ["termos"]) ? $arrayBody [0][$i] ["termos"] : "");

    $especialistasID = (isset($arrayBody [0][$i] ["especialistasID"]) ? $arrayBody [0][$i] ["especialistasID"] : "");
    $orgaoemissor = (isset($arrayBody [0][$i] ["orgaoemissor"]) ? $arrayBody [0][$i] ["orgaoemissor"] : "");
    $nr_identificacao = (isset($arrayBody [0][$i] ["nr_identificacao"]) ? $arrayBody [0][$i] ["nr_identificacao"] : "");
    $registro = (isset($arrayBody [0][$i] ["registro"]) ? $arrayBody [0][$i] ["registro"] : "");
    $UF = (isset($arrayBody [0][$i] ["UF"]) ? $arrayBody [0][$i] ["UF"] : "");
    $atuacao = (isset($arrayBody [0][$i] ["atuacao"]) ? $arrayBody [0][$i] ["atuacao"] : "");
    $periodo = (isset($arrayBody [0][$i] ["periodo"]) ? $arrayBody [0][$i] ["periodo"] : "");
    $perfilespecialista = (isset($arrayBody [0][$i] ["perfilespecialista"]) ? $arrayBody [0][$i] ["perfilespecialista"] : "");
    $habilidade = (isset($arrayBody [0][$i] ["habilidade"]) ? $arrayBody [0][$i] ["habilidade"] : "");
    $experiencia = (isset($arrayBody [0][$i] ["experiencia"]) ? $arrayBody [0][$i] ["experiencia"] : "");
    $minicv = (isset($arrayBody [0][$i] ["minicv"]) ? $arrayBody [0][$i] ["minicv"] : "");
    $disponibilidade = (isset($arrayBody [0][$i] ["disponibilidade"]) ? $arrayBody [0][$i] ["disponibilidade"] : "");
//$ativo = (isset($arrayBody [0][$i] ["ativo"]) ? $arrayBody [0][$i] ["ativo"] : "");

    var_dump($arrayBody [0][$i]);

//    if (1 == 2) {
    $query = "SELECT email FROM $tabela WHERE email = '$email'";
    $pesquisar = mysql_query($query, $db);
    $contagem = mysql_num_rows($pesquisar);

    if ($contagem == 1) {
        $retorno[$r]["status"] = "ERRO";
        $retorno[$r]["mensagem"] = "O email que você escolheu já está cadastrado." . $email;
        $r++;
    } else {
        $usuariosID = novo_usuario($perfilID, $nome, $tel, $cel, $email, $endereco, $bairro, $cep, $cidade, $estado, $cpf_cnpj, $rg);
        echo 'usuariosID: '.$usuariosID;
        novo_especialista($usuariosID, $atuacao);
    }
}
Echo 'fim';

function novo_usuario($perfilID, $nome, $tel, $cel, $email, $endereco, $bairro, $cep, $cidade, $estado, $cpf_cnpj, $rg) {
    include "../phpfunction/configuracao.php";
    $tabela = "usuarios";     //o nome de sua tabela
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);

    $querynovousuario = "INSERT INTO `$tabela` (nome, tel, cel, email, endereco, bairro, cep, cidade, estado, cpf_cnpj, rg, perfilID)
                                        VALUES ('$nome','$tel','$cel','$email','$endereco','$bairro','$cep','$cidade','$estado','$cpf_cnpj','$rg',$perfilID)";
    geralog($querynovousuario, $_SERVER["PHP_SELF"]);
    $cadastrar = mysql_query($querynovousuario, $db);
    $last_inserted = mysql_insert_id();
    $sqlerro = mysql_errno($db) . ':' . mysql_error($db);

    return $last_inserted;
}

function novo_especialista($usuariosID, $atuacao) {
    include "../phpfunction/configuracao.php";
    $tabela = "especialistas";     //o nome de sua tabela
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);
    $pesquisar = mysql_query("SELECT * FROM $tabela WHERE usuariosID = '$usuariosID'", $db);
    $contagem = mysql_num_rows($pesquisar);

    $querynovousuario = "INSERT INTO `$tabela` (usuariosID, atuacao, disponibilidade)
                                        VALUES ($usuariosID,'$atuacao','0')";
    geralog($querynovousuario, $_SERVER["PHP_SELF"]);

    $cadastrar = mysql_query($querynovousuario, $db);

    return;
}
