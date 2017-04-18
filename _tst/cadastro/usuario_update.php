<?php
ob_start();
include "../phpfunction/header_1.php";
include "../phpfunction/geralog.php";
include "../phpfunction/configuracao.php";
include "../phpfunction/userfunction.php";

$tabela = "usuarios";     //o nome de sua tabela
$db = mysql_connect($host, $login_db, $senha_db);
$basedados = mysql_select_db($database);

$entityBody = file_get_contents('php://input');
//$entityBody = file_get_contents('./class.txt', true);
//$entityBody = file_get_contents('./user.txt', true);
//var_dump($entityBody);
//geralog($entityBody, $_SERVER["PHP_SELF"]);
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
    $profilePicture = $_REQUEST ["profilePicture"];
    $cpf_cnpj = $_REQUEST ["cpf_cnpj"];
    $rg = $_REQUEST ["rg"];
    $endereco = $_REQUEST ["endereco"];
    $bairro = $_REQUEST ["bairro"];
    $cep = $_REQUEST ["cep"];
    $cidade = $_REQUEST ["cidade"];
    $estado = $_REQUEST ["estado"];
    $senha = $_REQUEST ["senha"];

    $termos = $_REQUEST ["termos"];

    $especialistasID = $_REQUEST ["especialistasID"];
    $orgaoemissor = $_REQUEST ["orgaoemissor"];
    $nr_identificacao = $_REQUEST ["nr_identificacao"];
    $registro = $_REQUEST ["registro"];
    $UF = $_REQUEST ["UF"];
    $atuacao = $_REQUEST ["atuacao"];
    $periodo = $_REQUEST ["periodo"];
    $perfilespecialista = $_REQUEST ["perfilespecialista"];
    $habilidade = $_REQUEST ["habilidade"];
    $experiencia = $_REQUEST ["experiencia"];
    $minicv = $_REQUEST ["minicv"];
    $classificacao = $_REQUEST ["classificacao"];
    $disponibilidade = $_REQUEST ["disponibilidade"];
    //$ativo              = $_REQUEST ["ativo"];
    $comentario = $_REQUEST ["comentario"];
    $pacientesID = $_REQUEST ["pacientesID"];
} else {
    $usuariosID = (isset($arrayBody [$i] ["usuariosID"]) ? $arrayBody [$i] ["usuariosID"] : "");
    $perfilID = (isset($arrayBody [$i] ["perfilID"]) ? $arrayBody [$i] ["perfilID"] : "");
    $nome = (isset($arrayBody [$i] ["nome"]) ? $arrayBody [$i] ["nome"] : "");
    $nascimento = (isset($arrayBody [$i] ["nascimento"]) ? $arrayBody [$i] ["nascimento"] : "");
    $sexo = (isset($arrayBody [$i] ["sexo"]) ? $arrayBody [$i] ["sexo"] : "");
    $tel = (isset($arrayBody [$i] ["tel"]) ? $arrayBody [$i] ["tel"] : "");
    $cel = (isset($arrayBody [$i] ["cel"]) ? $arrayBody [$i] ["cel"] : "");
    $email = (isset($arrayBody [$i] ["email"]) ? $arrayBody [$i] ["email"] : "");
    $profilePicture = (isset($arrayBody [$i] ["profilePicture"]) ? $arrayBody [$i] ["profilePicture"] : "");
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

    $especialistasID = (isset($arrayBody [$i] ["especialistasID"]) ? $arrayBody [$i] ["especialistasID"] : "");
    $orgaoemissor = (isset($arrayBody [$i] ["orgaoemissor"]) ? $arrayBody [$i] ["orgaoemissor"] : "");
    $nr_identificacao = (isset($arrayBody [$i] ["nr_identificacao"]) ? $arrayBody [$i] ["nr_identificacao"] : "");
    $registro = (isset($arrayBody [$i] ["registro"]) ? $arrayBody [$i] ["registro"] : "");
    $UF = (isset($arrayBody [$i] ["UF"]) ? $arrayBody [$i] ["UF"] : "");
    $atuacao = (isset($arrayBody [$i] ["atuacao"]) ? $arrayBody [$i] ["atuacao"] : "");
    $periodo = (isset($arrayBody [$i] ["periodo"]) ? $arrayBody [$i] ["periodo"] : "");
    $perfilespecialista = (isset($arrayBody [$i] ["perfilespecialista"]) ? $arrayBody [$i] ["perfilespecialista"] : "");
    $habilidade = (isset($arrayBody [$i] ["habilidade"]) ? $arrayBody [$i] ["habilidade"] : "");
    $experiencia = (isset($arrayBody [$i] ["experiencia"]) ? $arrayBody [$i] ["experiencia"] : "");
    $minicv = (isset($arrayBody [$i] ["minicv"]) ? $arrayBody [$i] ["minicv"] : "");
    $disponibilidade = (isset($arrayBody [$i] ["disponibilidade"]) ? $arrayBody [$i] ["disponibilidade"] : "");
    //$ativo = (isset($arrayBody [$i] ["ativo"]) ? $arrayBody [$i] ["ativo"] : "");

    $myclass = (isset($arrayBody [$i] ["myclass"]) ? $arrayBody [$i] ["myclass"] : "0");
    $comentario = (isset($arrayBody [$i] ["comentario"]) ? $arrayBody [$i] ["comentario"] : "");
    $pacientesID = (isset($arrayBody [$i] ["pacientesID"]) ? $arrayBody [$i] ["pacientesID"] : "");
}

$retorno = array();
$return_usuario = array();
$return_especialista = array();
$return_classificacao = array();

if ($email != '') {
    if (calc_idade($nascimento) < 18) {
        $retorno[$i]["status"] = "ERRO";
        $retorno[$i]["mensagem"] = "Olá, obrigado pelo seu interesse na nossa plataforma.\n\nPercebemos que você ainda não é maior de 18 anos, e infelizmente\nnão podemos concluir seu cadastro.\n\nAssim que você completar essa idade, será um prazer te receber aqui\nnovamente para que você possa ser um profissional cadastrado na nossa plataforma.\n\nEm caso de dúvidas, por favor entre em contato\n\nObrigado.";
    } else {
        if ($usuariosID == "") { //novo_usuario
            $query = "SELECT email FROM $tabela WHERE email = '$email'";
            geralog($query, $_SERVER["PHP_SELF"]);
            $pesquisar = mysql_query($query, $db);
            $contagem = mysql_num_rows($pesquisar);

            if ($contagem == 1) {
                geralog("O email que você escolheu já está cadastrado.", $_SERVER["PHP_SELF"]);
                $retorno[$i]["status"] = "ERRO";
                $retorno[$i]["mensagem"] = "O email que você escolheu já está cadastrado.";
                $i++;
            }
            if ($i > 0) {
                http_response_code(400);
            } else {
                $return_usuario = novo_usuario($perfilID, $nome, $nascimento, $sexo, $tel, $cel, $email, $profilePicture, $cpf_cnpj, $rg, $endereco, $bairro, $cep, $cidade, $estado, $senha, $termos);
                //var_dump($return_usuario);
                $msg_usuario = $return_usuario[0];
                if ($msg_usuario["status"] == "OK") {
                    $usuariosID = $return_usuario[1]["usuariosID"];
                    $return_especialista = novo_especialista($usuariosID, $orgaoemissor, $nr_identificacao, $registro, $UF, $atuacao, $periodo, $perfilespecialista, $habilidade, $experiencia, $minicv, $disponibilidade);
                    // testar retorno especialista
                    include '../SendGrid/BemVindoProfissional.php';
                    http_response_code(200);
                } else {
                    //
                    http_response_code(400);
                }
            }
        } else {

            $return_usuario = update_usuario($usuariosID, $perfilID, $nome, $nascimento, $sexo, $tel, $cel, $profilePicture, $cpf_cnpj, $rg, $endereco, $bairro, $cep, $cidade, $estado, $senha);
            $msg_usuario = $return_usuario[0];
            if ($msg_usuario["status"] == "OK") {
                if ($especialistasID == "") { //novo_especialista
                    $return_especialista = novo_especialista($usuariosID, $orgaoemissor, $nr_identificacao, $registro, $UF, $atuacao, $periodo, $perfilespecialista, $habilidade, $experiencia, $minicv, $disponibilidade);
                    // testar retorno especialista
                    http_response_code(200);
                } else {
                    $return_especialista = update_especialista($usuariosID, $especialistasID, $orgaoemissor, $nr_identificacao, $registro, $UF, $atuacao, $periodo, $perfilespecialista, $habilidade, $experiencia, $minicv, $disponibilidade);
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
        if (count($return_especialista) > 0) {
            $retorno[$i]["status"] = $return_especialista[0]["status"];
            $retorno[$i]["mensagem"] = $return_especialista[0]["mensagem"];
            $i++;
        }
    }
}
if (!($myclass == "0")) {
    $return_especialista = update_classificacao($especialistasID, $pacientesID, $myclass, $comentario);
    if (count($return_especialista) > 0) {
        $retorno[$i]["status"] = $return_especialista[0]["status"];
        $retorno[$i]["mensagem"] = $return_especialista[0]["mensagem"];
        $i++;
        $nomeespecialista = '';
        $emailespecialista = '';
        especialistas($especialistasID);
        $nomepaciente = '';
        pacientes($pacientesID);
        $nome=$nomepaciente;
        include '../SendGrid/Evaluate.php';
    }
}


//var_dump($retorno) . '</br>';
$json_retorno = json_encode($retorno);
//geralog($json_retorno, $_SERVER["PHP_SELF"]);
//var_dump($json_retorno) . '</br>';
http_response_code();
echo $json_retorno;

function update_classificacao($especialistasID, $pacientesID, $myclass, $comentario) {
    include "../phpfunction/configuracao.php";

    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);

    $tabela = "especialistas_classificacao";     //o nome de sua tabela
    //Verifica se existe nota deste paciente para o profissional
    $queryselect = "SELECT especialistas_classificacaoID, classificacao "
            . "from $tabela "
            . "WHERE "
            . "especialistasID = $especialistasID and "
            . "pacientesID = $pacientesID";

    $resultselect = mysql_query($queryselect, $db);
    $contagem = mysql_num_rows($resultselect);
    //echo $queryselect;

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

Function pacientes($pacientesID) {
    global $db, $basedados;
    global $nomepaciente;

    $queryselect = "
        SELECT usuarios.nome as nomepaciente
        FROM usuarios 
        INNER JOIN pacientes
        ON usuarios.usuariosID=pacientes.usuariosID
        where pacientes.pacientesID=$pacientesID";
    $resultselect = mysql_query($queryselect, $db) or die($queryselect . "<br/><br/>" . mysql_error());
    $nomepaciente = '';
    while ($linha = mysql_fetch_array($resultselect)) {
        $nomepaciente = $linha["nomepaciente"];
    }
    //echo 'mensagem 1: ' . $pacientesID;

    return (TRUE);
}

function novo_usuario($perfilID, $nome, $nascimento, $sexo, $tel, $cel, $email, $profilePicture, $cpf_cnpj, $rg, $endereco, $bairro, $cep, $cidade, $estado, $senha, $termos) {
    include "../phpfunction/configuracao.php";
    $tabela = "usuarios";     //o nome de sua tabela
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);

    $localizacao = geo_address($endereco, $bairro, $cep, $cidade, $estado);
    $latitude = $localizacao[0];
    $longitude = $localizacao[1];


    $querynovousuario = "INSERT INTO `$tabela` (nome, nascimento, sexo, tel, cel, email, cpf_cnpj, rg, endereco, bairro, cep, cidade, estado, latitude, longitude, senha, perfilID, foto, termos)
                                        VALUES ('$nome','$nascimento','$sexo','$tel','$cel','$email','$cpf_cnpj','$rg','$endereco','$bairro','$cep','$cidade','$estado','$latitude','$longitude',AES_ENCRYPT('$senha','password'),$perfilID,'$profilePicture','$termos')";
    geralog('INSERT email: ' . $email, $_SERVER["PHP_SELF"]);
    $cadastrar = mysql_query($querynovousuario, $db);
    $sqlerro = mysql_errno($db) . ':' . mysql_error($db);
    geralog($sqlerro, $_SERVER["PHP_SELF"]);

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

function update_usuario($usuariosID, $perfilID, $nome, $nascimento, $sexo, $tel, $cel, $profilePicture, $cpf_cnpj, $rg, $endereco, $bairro, $cep, $cidade, $estado, $senha) {
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
            . "`latitude` = '$latitude ' , "
            . "`longitude` = '$longitude' , ";
    if (!$profilePicture == "") {
        $queryupdate = $queryupdate
                . "`foto` = '$profilePicture' , ";
    }
    $queryupdate = $queryupdate
            . "`senha` = AES_ENCRYPT('$senha','password')"
            . " WHERE usuariosID = $usuariosID";
    //geralog($queryupdate, $_SERVER["PHP_SELF"]);

    $cadastrar = mysql_query($queryupdate, $db);
    geralog($cadastrar, $_SERVER["PHP_SELF"]);
    $retorno = array();

    $i = 0;
    if ($cadastrar == 1) {
        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Usuário Alterado com sucesso";
    } else {
        $retorno[$i]["status"] = "ERRO";
        $retorno[$i]["mensagem"] = "Usuário não Alterado";
    }
    return $retorno;
}

function novo_especialista($usuariosID, $orgaoemissor, $nr_identificacao, $registro, $UF, $atuacao, $periodo, $perfilespecialista, $habilidade, $experiencia, $minicv, $disponibilidade) {
    include "../phpfunction/configuracao.php";
    $tabela = "especialistas";     //o nome de sua tabela
    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);
    $pesquisar = mysql_query("SELECT * FROM $tabela WHERE usuariosID = '$usuariosID'", $db);
    $contagem = mysql_num_rows($pesquisar);
    $retorno = array();
    $i = 0;

    if ($contagem == 1) {
        $retorno[$i]["status"] = "ERRO";
        $retorno[$i]["mensagem"] = "Profissional já cadastrado";
        $i++;
    }

    if ($i == 0) {
        $querynovousuario = "INSERT INTO `$tabela` (usuariosID, orgaoemissor, nr_identificacao, registro, UF, atuacao, periodo, perfilespecialista, habilidade, experiencia, minicv, disponibilidade)
                                        VALUES ($usuariosID,'$orgaoemissor','$nr_identificacao','$registro','$UF','$atuacao','$periodo','$perfilespecialista','$habilidade','$experiencia','$minicv','$disponibilidade')";
        geralog($querynovousuario, $_SERVER["PHP_SELF"]);

        $cadastrar = mysql_query($querynovousuario, $db);
        geralog($cadastrar, $_SERVER["PHP_SELF"]);

        if ($cadastrar == 1) {
            $retorno[$i]["status"] = "OK";
            $retorno[$i]["mensagem"] = "Profissional incluido com sucesso";
            $i++;
        } else {
            $retorno[$i]["status"] = "ERRO";
            $retorno[$i]["mensagem"] = "Profissional não incluido";
            $i++;
        }
    }
    return $retorno;
}

function update_especialista($usuariosID, $especialistasID, $orgaoemissor, $nr_identificacao, $registro, $UF, $atuacao, $periodo, $perfilespecialista, $habilidade, $experiencia, $minicv, $disponibilidade) {
    include "../phpfunction/configuracao.php";
    $tabela = "especialistas";     //o nome de sua tabela

    $db = mysql_connect($host, $login_db, $senha_db);
    $basedados = mysql_select_db($database);

    $queryupdate = "UPDATE $tabela SET "
            . "`orgaoemissor` = '$orgaoemissor' , "
            . "`nr_identificacao` = '$nr_identificacao' , "
            . "`registro` = '$registro' , "
            . "`UF` = '$UF' , "
            . "`atuacao` = '$atuacao' , "
            . "`periodo` = '$periodo' , "
            . "`perfilespecialista` = '$perfilespecialista' , "
            . "`habilidade` = '$habilidade'   , "
            . "`experiencia` = '$experiencia'   , "
            . "`minicv` = '$minicv'   , "
            . "`disponibilidade` = '$disponibilidade'  WHERE especialistasID = $especialistasID";
    geralog($queryupdate, $_SERVER["PHP_SELF"]);
    $cadastrar = mysql_query($queryupdate, $db);
    geralog($cadastrar, $_SERVER["PHP_SELF"]);
    $retorno = array();
    $i = 0;

    if ($cadastrar == 1) {
        $retorno[$i]["status"] = "OK";
        $retorno[$i]["mensagem"] = "Profissional Alterado com sucesso";
        $i++;
    } else {
        $retorno[$i]["status"] = "ERRO";
        $retorno[$i]["mensagem"] = "Profissional não Alterado";
        $i++;
    }
    return $retorno;
}

function geo_address($endereco, $bairro, $cep, $cidade, $estado) {
    $address = urlencode($endereco . ', ' . $bairro . ', ' . $cep . ', ' . $cidade . ', ' . $estado);

    $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

    $resp_json = file_get_contents_curl($url);
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
