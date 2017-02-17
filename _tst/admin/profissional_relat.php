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
        $PHP_SELF = "../admin/profissional_relat.php";
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

        $querytabela = "SELECT usuarios.usuariosID, usuarios.data, nome, nascimento, sexo, tel, cel, email, cpf_cnpj, rg, endereco, bairro, cep, cidade, estado, termos, especialistasID, orgaoemissor, nr_identificacao, registro, UF, atuacao, periodo, perfilespecialista, habilidade, experiencia, classificacao, total, disponibilidade, ativo FROM usuarios LEFT JOIN especialistas ON especialistas.usuariosID=usuarios.usuariosID WHERE perfilID = 2";

        // Faz o Select pegando o registro inicial até a quantidade de registros para página	

        $sql = mysql_query($querytabela . " LIMIT $inicial, $numreg", $db);
        // Serve para contar quantos registros você tem na seua tabela para fazer a paginação	
        $sql_conta = mysql_query($querytabela, $db);
        $quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação
        //echo $querytabela . "<BR>";
        //echo $quantreg . "<BR>";

        echo "<table border='1' width='300%' class='sortable'  >";
        echo "<tr>";
        echo "<td width='200px'>" . 'nome' . "</td>";
        echo "<td>" . 'ativo' . "</td>";
        echo "<td>" . 'Cadastrado' . "</td>";
        echo "<td>" . 'nascimento' . "</td>";
        echo "<td>" . 'sexo' . "</td>";
        echo "<td>" . 'tel' . "</td>";
        echo "<td>" . 'cel' . "</td>";
        echo "<td>" . 'email' . "</td>";
        echo "<td>" . 'cpf_cnpj' . "</td>";
        echo "<td>" . 'rg' . "</td>";
        echo "<td>" . 'endereco' . "</td>";
        echo "<td>" . 'bairro' . "</td>";
        echo "<td>" . 'cep' . "</td>";
        echo "<td>" . 'cidade' . "</td>";
        echo "<td>" . 'estado' . "</td>";
        echo "<td>" . 'nascimento' . "</td>";
        echo "<td>" . 'termos' . "</td>";
        echo "<td>" . 'especialistasID' . "</td>";
        echo "<td>" . 'orgaoemissor' . "</td>";
        echo "<td>" . 'nr_identificacao' . "</td>";
        echo "<td>" . 'registro' . "</td>";
        echo "<td>" . 'UF' . "</td>";
        echo "<td>" . 'atuacao' . "</td>";
        echo "<td>" . 'periodo' . "</td>";
        echo "<td>" . 'perfilespecialista' . "</td>";
        echo "<td>" . 'habilidade' . "</td>";
        echo "<td>" . 'experiencia' . "</td>";
        echo "<td>" . 'classificacao' . "</td>";
        echo "<td>" . 'total' . "</td>";
        echo "<td>" . 'disponibilidade' . "</td>";
        echo "</tr>";

        while ($aux = mysql_fetch_array($sql)) {
            $usuariosID = $aux['usuariosID'];
            $especialistasID = $aux['especialistasID'];
            $botao = ativo($aux['ativo']);
            $no_ativo = no_ativo($aux['ativo']);
            echo "<tr>";
            echo "<td>" . $aux['nome'] . "</td>";
            echo "<td>"
            . "<BUTTON onclick="
            . '"'
            . "window.location.href="
            . "'../phpfunction/ativar.php?especialistasID=$especialistasID&ativo=$no_ativo'"
            . '">'
            . $botao
            . "</BUTTON>"
            . "</td>";

            echo "<td>" . $aux['data'] . "</td>";
            echo "<td>" . $aux['nascimento'] . "</td>";
            echo "<td>" . $aux['sexo'] . "</td>";
            echo "<td>" . $aux['tel'] . "</td>";
            echo "<td>" . $aux['cel'] . "</td>";
            echo "<td>" . $aux['email'] . "</td>";
            echo "<td>" . $aux['cpf_cnpj'] . "</td>";
            echo "<td>" . $aux['rg'] . "</td>";
            echo "<td>" . $aux['endereco'] . "</td>";
            echo "<td>" . $aux['bairro'] . "</td>";
            echo "<td>" . $aux['cep'] . "</td>";
            echo "<td>" . $aux['cidade'] . "</td>";
            echo "<td>" . $aux['estado'] . "</td>";
            echo "<td>" . $aux['nascimento'] . "</td>";
            echo "<td>" . $aux['termos'] . "</td>";
            echo "<td>" . $aux['especialistasID'] . "</td>";
            echo "<td>" . $aux['orgaoemissor'] . "</td>";
            echo "<td>" . $aux['nr_identificacao'] . "</td>";
            echo "<td>" . $aux['registro'] . "</td>";
            echo "<td>" . $aux['UF'] . "</td>";
            echo "<td>" . cargo($aux['atuacao']) . "</td>";
            echo "<td>" . periodo($aux['periodo']) . "</td>";
            echo "<td>" . perfilespecialista($aux['perfilespecialista']) . "</td>";
            echo "<td>" . habilidade($aux['habilidade']) . "</td>";
            echo "<td>" . $aux['experiencia'] . "</td>";
            echo "<td>" . $aux['classificacao'] . "</td>";
            echo "<td>" . $aux['total'] . "</td>";
            echo "<td>" . $aux['disponibilidade'] . "</td>";
            echo "</tr>";
        }


        echo "</table>";

        include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >>		echo "<br><br>"; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo		while ($aux = mysql_fetch_array($sql)) {		/* Ai o resto é com voces em montar como deve parecer o conteúdo */	}
        ?>
    </body>
</html>



