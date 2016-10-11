<?php

include "../phpfunction/configuracao.php";
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$ativo = filter_input(INPUT_GET, 'ativo', FILTER_SANITIZE_ENCODED);
$especialistasID = filter_input(INPUT_GET, 'especialistasID', FILTER_SANITIZE_ENCODED);
$tabela2 = "especialistas";     //o nome de sua tabela

$queryupdate = "UPDATE $tabela2 SET `ativo` = '$ativo' WHERE especialistasID = $especialistasID";
$cadastrar = mysql_query($queryupdate, $db);
//echo $queryupdate . $cadastrar . '<br>' ;
$sqlerro = mysql_errno($db) . ' : ' . mysql_error($db);
// echo $sqlerro;
mysql_close($db);
?>
<script>
    window.history.back();
</script>