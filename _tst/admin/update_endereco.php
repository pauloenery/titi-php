<html lang="pt_br">
    <meta charset="utf-8" />
    <?php
    include "../phpfunction/userfunction.php";
    include "../phpfunction/configuracao.php";
    $tabela = "usuarios";     //o nome de sua tabela

    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);

    $usuariosID = filter_input(INPUT_GET, 'usuariosID', FILTER_SANITIZE_ENCODED);
    $myquery = "SELECT usuariosID, endereco, bairro, cep, cidade, estado  FROM $tabela WHERE usuariosID = $usuariosID";

    $pesquisar = mysql_query($myquery, $db);
    $contagem = mysql_num_rows($pesquisar);

    $errors = "";
    if ($contagem == 0) {
        $errors .= "- O email que você escolheu não está cadastrado.\\n" . $myquery;
    }

    if ($errors == "") {
        while ($linha = mysql_fetch_array($pesquisar)) {
            $endereco = $linha["endereco"];
            $bairro = $linha["bairro"];
            $cep = $linha["cep"];
            $cidade = $linha["cidade"];
            $estado = $linha["estado"];
        }

        $address = urlencode($endereco . ', ' . $bairro . ', ' . $cep . ', ' . $cidade . ', ' . $estado);

        echo $address . "<br>";

        $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";
        echo $url . "<br>";

        $resp_json = file_get_contents_curl($url);
        $resp = json_decode($resp_json, true);

        $latitude = '';
        $longitude = '';

        if ($resp['status'] == 'OK'):

            $i = 0;

            $latitude = $resp['results'][$i]['geometry']['location']['lat'];
            $longitude = $resp['results'][$i]['geometry']['location']['lng'];


        endif;
        echo $resp['status'];

        $queryupdate = "UPDATE $tabela SET "
                . "`latitude` = '$latitude' , "
                . "`longitude` = '$longitude'  "
                . " WHERE usuariosID = $usuariosID";

        Echo $queryupdate . "<br>";

        $cadastrar = mysql_query($queryupdate, $db);

        echo $cadastrar;

        if ($cadastrar == 1) {
            echo "<script>\n";
            echo "alert('Latitude: $latitude \\n Longitude: $longitude ');\n";
            echo "history.back();\n";
            echo "</script>";
        }
    } else {
        echo "<script>\n";
        echo "alert('Ocorreram os seguintes erros ao tentar se cadastrar: \\n $errors ');\n";
        echo "history.back();\n";
        echo "</script>";
    }
    ?>
