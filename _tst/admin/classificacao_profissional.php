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
    <style>
/* Sortable tables */
table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
}

    </style>
    <script src="sorttable.js"></script>

    <body>
        <?php
        $PHP_SELF = "../admin/classificacao_profissional.php";
        include "../phpfunction/configuracao.php";
        include "../phpfunction/userfunction.php";

        $db = mysql_connect($host, $login_db, $senha_db);
        $basedados = mysql_select_db($database);

        //######### INICIO Paginação	
        $numreg = 10; // Quantos registros por página vai ser mostrado	
        $pg = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_ENCODED);
        $max = filter_input(INPUT_GET, 'max', FILTER_SANITIZE_ENCODED);

        if (!isset($pg)) {
            $pg = 0;
        }
        if (!isset($max)) {
            $max = $numreg;
        }
        if ($max > 0) {
            $numreg = $max;
        }
        $param = "&max=" . $max;
        $inicial = $pg * $numreg; //######### FIM dados Paginação		

        $querytabela = "
        SELECT 
            usuarios.usuariosID,
            especialistas.especialistasID,
            usuarios.nome,
            especialistas.experiencia,            
            especialistas.classificacao,
            especialistas.total,
            userpaciente.usuariosID as userpacienteID,
            especialistas_classificacao.pacientesID,
            userpaciente.nome as nomepaciente,
            especialistas_classificacao.classificacao as classificacaoindividual,
            especialistas_classificacao.comentario,
            especialistas_classificacao.data
        FROM especialistas 
        INNER JOIN usuarios
        ON especialistas.usuariosID=usuarios.usuariosID
        INNER JOIN especialistas_classificacao
        ON especialistas.especialistasID=especialistas_classificacao.especialistasID
        INNER JOIN pacientes
        ON especialistas_classificacao.pacientesID=pacientes.pacientesID
        INNER JOIN usuarios as userpaciente
        ON pacientes.usuariosID=userpaciente.usuariosID
        ORDER BY usuarios.nome
                                ";

        // Faz o Select pegando o registro inicial até a quantidade de registros para página	

        $sql = mysql_query($querytabela . " LIMIT $inicial, $numreg", $db);
        // Serve para contar quantos registros você tem na seua tabela para fazer a paginação	
        $sql_conta = mysql_query($querytabela, $db);
        $quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação
        //echo $querytabela . "<BR>";
        //echo $quantreg . "<BR>";

        echo "<table border='1' width='100%' class='sortable' >";
        echo "<tr>";
        echo "<td>" . 'Nome do Profissional' . "</td>";
        echo "<td width='25%'>" . 'Experiência' . "</td>";
        echo "<td>" . 'Classificacao' . "</td>";
        echo "<td>" . 'Total' . "</td>";
        echo "<td>" . 'Nome do Paciente' . "</td>";
        echo "<td>" . 'Nota Individual' . "</td>";
        echo "<td width='25%'>" . 'Comentario' . "</td>";
        echo "<td>" . 'Data' . "</td>";
        echo "</tr>";

        while ($aux = mysql_fetch_array($sql)) {
            echo "<tr>";
            echo "<td>" . $aux['nome'] . "</td>";
            echo "<td>" . $aux['experiencia'] . "</td>";
            echo "<td>" . $aux['classificacao'] . "</td>";
            echo "<td>" . $aux['total'] . "</td>";
            echo "<td>" . $aux['nomepaciente'] . "</td>";
            echo "<td>" . $aux['classificacaoindividual'] . "</td>";
            echo "<td>" . $aux['comentario'] . "</td>";
            echo "<td>" . $aux['data'] . "</td>";
            echo "</tr>";
        }


        echo "</table>";

        include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >>		echo "<br><br>"; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo		while ($aux = mysql_fetch_array($sql)) {		/* Ai o resto é com voces em montar como deve parecer o conteúdo */	}
        ?>
    </body>
</html>



