<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $PHP_SELF = "../admin/monitor_relat.php";
        include "../phpfunction/configuracao.php";
        $db = mysql_connect($host, $login_db, $senha_db);
        $basedados = mysql_select_db($database);

        //######### INICIO Paginação	
        $numreg = 10; // Quantos registros por página vai ser mostrado	
        $pg = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_ENCODED);
        $tabela = filter_input(INPUT_GET, 'tabela', FILTER_SANITIZE_ENCODED);

        if (!isset($pg)) {
            $pg = 0;
        }

        $param = "&tabela=$tabela";
        $inicial = $pg * $numreg; //######### FIM dados Paginação		

        $querytabela = "SELECT * from $tabela";
        // Faz o Select pegando o registro inicial até a quantidade de registros para página	

        $sql = mysql_query($querytabela . " LIMIT $inicial, $numreg", $db);
        // Serve para contar quantos registros você tem na seua tabela para fazer a paginação	
        $sql_conta = mysql_query($querytabela, $db);
        $quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação
        //echo $querytabela . "<BR>";
        //echo $quantreg . "<BR>";

        echo "<table>";

        while ($aux = mysql_fetch_array($sql)) {
            $it = count($aux) / 2;

            echo "<tr>";
            $i = 0;
            for ($i = 0; $i < $it; $i++) {
                echo "<td>" . $aux[$i] . "</td>";
            }
            echo "</tr>";
        }


        echo "</table>";

        include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >>		echo "<br><br>"; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo		while ($aux = mysql_fetch_array($sql)) {		/* Ai o resto é com voces em montar como deve parecer o conteúdo */	}
        ?>
    </body>
</html>




