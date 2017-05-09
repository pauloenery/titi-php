<?php

//include "../phpfunction/header_1.php";
//include "../phpfunction/geralog.php";
include "../phpfunction/configuracao.php";
include "../phpfunction/userfunction.php";
include "../phpfunction/base.php";

$tabela = "usuarios";     //o nome de sua tabela
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$especialistasID = $_REQUEST ["especialistasID"];
$nome = $_REQUEST ["nomepaciente"];
$email = $_REQUEST ["emailpaciente"];
$myclass = (isset($_REQUEST ["rating"]) ? $_REQUEST ["rating"] : 0);
$comentario = $_REQUEST ["comentario"];

//echo 'especialistasID: ' . $especialistasID . ' - ';
//echo 'nomepaciente: ' . $nome . ' - ';
//echo 'emailpaciente: ' . $email . ' - ';
//echo 'myclass: ' . $myclass . ' - ';
//echo 'comentario: ' . $comentario . ' - ';
if (usuariosID($email)) {
    echo("<script>alert('Email inválido : $email ');</script>");
    echo("<script>history.back();</script>");
} elseif (($nome != '') || ($email != '') || ($myclass != 0)) {
    $pacientesID = pacientesID($email);
    IF ($pacientesID == 0) {
        //echo 'mensagem 2: ' . $pacientesID;
        $usuariosID = novo_usuario(3, $nome, $email);
        $pacientesID = novo_paciente($usuariosID);
    }
    IF ($pacientesID != 0) {
        update_classificacao($especialistasID, $pacientesID, $myclass, $comentario);
    }
    $nomeespecialista = '';
    $emailespecialista = '';
    especialistas($especialistasID);

    include '../SendGrid/Evaluate.php';
    echo("<script>alert('Obrigado por colaborar com a sua avaliação ');</script>");
    echo("<script>location.href = '" .$homeUrl."';</script>");
}

Function usuariosID($email) {
    global $db, $basedados;
    $queryselect = "
        SELECT usuariosID
        FROM usuarios 
        where email='$email' and perfilID=2";
    $resultselect = mysql_query($queryselect, $db) or die($queryselect . "<br/><br/>" . mysql_error());
    $contagem = mysql_num_rows($resultselect);
    if ($contagem == 1) {
        return (TRUE);
    } else {
        return (FALSE);
    }
}

Function especialistas($especialistasID) {
    global $db, $basedados;
    global $nomeespecialista, $emailespecialista;

    $queryselect = "
        SELECT usuarios.nome as nomeespecialista,
               usuarios.email as emailespecialista
        FROM usuarios 
        INNER JOIN especialistas
        ON usuarios.usuariosID=especialistas.usuariosID
        where especialistas.especialistasID=$especialistasID";
    $resultselect = mysql_query($queryselect, $db) or die($queryselect . "<br/><br/>" . mysql_error());
    $nomeespecialista = '';
    $emailespecialista = '';
    while ($linha = mysql_fetch_array($resultselect)) {
        $nomeespecialista = $linha["nomeespecialista"];
        $emailespecialista = $linha["emailespecialista"];
    }
    //echo 'mensagem 1: ' . $pacientesID;

    return (TRUE);
}

Function pacientesID($email) {
    global $db, $basedados;
    $queryselect = "
        SELECT pacientesID
        FROM pacientes 
        INNER JOIN usuarios
        ON pacientes.usuariosID=usuarios.usuariosID
        where email='$email'";
    $resultselect = mysql_query($queryselect, $db) or die($queryselect . "<br/><br/>" . mysql_error());
    $pacientesID = 0;
    while ($linha = mysql_fetch_array($resultselect)) {
        $pacientesID = $linha["pacientesID"];
    }
    //echo 'mensagem 1: ' . $pacientesID;

    return ($pacientesID);
}

function novo_usuario($perfilID, $nome, $email) {
    global $db, $basedados;

    $tabela = "usuarios";     //o nome de sua tabela

    $querynovousuario = "INSERT INTO `$tabela` (nome, email, perfilID)
                                        VALUES ('$nome','$email',$perfilID)";
    $cadastrar = mysql_query($querynovousuario, $db);
    $sqlerro = mysql_errno($db) . ':' . mysql_error($db) . '\\n';
    $last_inserted = mysql_insert_id();

    return $last_inserted;
}

function novo_paciente($usuariosID) {
    global $db, $basedados;
    $tabela = "pacientes";     //o nome de sua tabela

    $pesquisar = mysql_query("SELECT pacientesID FROM $tabela WHERE usuariosID = '$usuariosID'", $db);
    $contagem = mysql_num_rows($pesquisar);

    if ($contagem == 1) {
        while ($linha = mysql_fetch_array($pesquisar)) {
            $pacientesID = $linha["pacientesID"];
        }
    } else {
        $querynovousuario = "INSERT INTO `$tabela` (usuariosID)
                                        VALUES ($usuariosID)";

        $cadastrar = mysql_query($querynovousuario, $db);
        $last_inserted = mysql_insert_id();
    }
    return $last_inserted;
}

function update_classificacao($especialistasID, $pacientesID, $myclass, $comentario) {
    global $db, $basedados;

    $tabela = "especialistas_classificacao";     //o nome de sua tabela
//Verifica se existe nota deste paciente para o profissional
    $queryselect = "SELECT especialistas_classificacaoID, classificacao "
            . "from $tabela "
            . "WHERE "
            . "especialistasID = $especialistasID and "
            . "pacientesID = $pacientesID";
    //echo $queryselect;

    $resultselect = mysql_query($queryselect, $db);
    $contagem = mysql_num_rows($resultselect);

    if ($contagem == 1) {    //encontrou uma nota altera a classificação 
        $queryupdate = "UPDATE $tabela SET "
                . "`classificacao` = '$myclass' , "
                . "`comentario` = '$comentario'  "
                . "WHERE "
                . "especialistasID = $especialistasID and "
                . "pacientesID = $pacientesID";
        $resultupdate = mysql_query($queryupdate, $db);
    } else {                 // não encontrou insere uma classificação 
        $queryinsert = "INSERT INTO `$tabela` (especialistasID, pacientesID, classificacao, comentario)
                            VALUES ('$especialistasID','$pacientesID','$myclass','$comentario')";
        $resultinsert = mysql_query($queryinsert, $db);
    }
    $queryselect = "SELECT count(*) AS total, AVG(classificacao) AS classificacao "
            . "FROM "
            . "$tabela "
            . "where "
            . "especialistasID = $especialistasID";
    $resultselect = mysql_query($queryselect, $db);

    $classificacaoDb = 0;
    $totalDb = 0;
    while ($linha = mysql_fetch_array($resultselect)) {
        $classificacaoDb = $linha["classificacao"];
        $totalDb = $linha["total"];
    }


    $tabela = "especialistas";     //o nome de sua tabela
    $queryupdate = "UPDATE $tabela SET "
            . "`classificacao` = '$classificacaoDb' , "
            . "`total` = '$totalDb' "
            . "WHERE "
            . "especialistasID = $especialistasID";

    $cadastrar = mysql_query($queryupdate, $db);
    $retorno = array();
    $i = 0;

    if ($cadastrar == 1) {
        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Classificação Alterado com sucesso";
        $i++;
    } else {
        $retorno[$i]["status"] = "ERRO";
        $retorno[$i]["mensagem"] = "Classificação não Alterada";
        $i++;
    }
    return $retorno;
}
