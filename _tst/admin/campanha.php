<?php
set_time_limit(3600);
ignore_user_abort(true);

include "../phpfunction/header_1.php";
include "../phpfunction/userfunction.php";
include "../phpfunction/configuracao.php";
include "../phpfunction/geralog.php";

include '../SendGrid/Campanha.php';

$campanha = $_GET ["campanha"];

$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$queryprofissional = "SELECT 
            usuarios.nome,
            usuarios.email
                FROM usuarios
                where perfilID=2 and campanha='$campanha'";

$sql = mysql_query($queryprofissional, $db) or die($queryprofissional . "<br/><br/>" . mysql_error());


geralog('Inicio campanha: '.$campanha, $_SERVER["PHP_SELF"]);

while ($dados = mysql_fetch_array($sql)) {

    $nome = $dados["nome"];
    $email = $dados["email"];

    sendmail($nome, $email);
    geralog('nome: ' . $nome . ' email: ' . $email, $_SERVER["PHP_SELF"]);

}
geralog('Fim  campanha: '.$campanha, $_SERVER["PHP_SELF"]);
?>
