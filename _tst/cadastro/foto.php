<?php
/**
 * Upload de Imagens com Seguran�a
 *
 * @author Alfred Reinold Baudisch
 * @email alfred_baudisch@hotmail.com
 * @date Jan 09, 2004
 * @changes Jan 14, 2004 - v2.0
 */
// Prepara a vari�vel caso o formul�rio tenha sido postado
$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;

$config = array();
// Tamano m�ximo da imagem, em bytes
$config["tamanho"] = 106883;
// Largura M�xima, em pixels
$config["largura"] = 350;
// Altura M�xima, em pixels
$config["altura"] = 250;
// Diret�rio onde a imagem ser� salva
$config["diretorio"] = "fotos/";

// Gera um nome para a imagem e verifica se j� n�o existe, caso exista, gera outro nome e assim sucessivamente..
// Fun��o Recursiva
function nome($extensao) {
    global $config;

    // Gera um nome �nico para a imagem
    $temp = substr(md5(uniqid(time())), 0, 10);
    $imagem_nome = $temp . "." . $extensao;

    // Verifica se o arquivo j� existe, caso positivo, chama essa fun��o novamente
    if (file_exists($config["diretorio"] . $imagem_nome)) {
        $imagem_nome = nome($extensao);
    }

    return $imagem_nome;
}

if ($arquivo) {
    $erro = array();

    // Verifica o mime-type do arquivo para ver se � de imagem.
    // Caso fosse verificar a extens�o do nome de arquivo, o c�digo deveria ser:
    //
    // if(!eregi("\.(jpg|jpeg|bmp|gif|png){1}$", $arquivo["name"])) {
    //      $erro[] = "Arquivo em formato inv�lido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo"; }
    //
    // Mas, o que ocorre � que alguns usu�rios mal-intencionados, podem pegar um v�rus .exe e simplesmente mudar a extens�o
    // para alguma das imagens e enviar. Ent�o, n�o adiantaria em nada verificar a extens�o do nome do arquivo.
    if (!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"])) {
        $erro[] = "Arquivo em formato inv�lido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
    } else {
        // Verifica tamanho do arquivo
        if ($arquivo["size"] > $config["tamanho"]) {
            $erro[] = "Arquivo em tamanho muito grande! A imagem deve ser de no m�ximo " . $config["tamanho"] . " bytes. Envie outro arquivo";
        }

        // Para verificar as dimens�es da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);

        // Verifica largura
        if ($tamanhos[0] > $config["largura"]) {
            $erro[] = "Largura da imagem n�o deve ultrapassar " . $config["largura"] . " pixels";
        }

        // Verifica altura
        if ($tamanhos[1] > $config["altura"]) {
            $erro[] = "Altura da imagem n�o deve ultrapassar " . $config["altura"] . " pixels";
        }
    }

    if (!sizeof($erro)) {
        // Pega extens�o do arquivo, o indice 1 do array conter� a extens�o
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);

        // Gera nome �nico para a imagem
        $imagem_nome = nome($ext[1]);

        // Caminho de onde a imagem ficar�
        $imagem_dir = $config["diretorio"] . $imagem_nome;

        // Faz o upload da imagem
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
    }
}
?>
<html>
    <head>
        <title>Enviar Foto</title>
        <style type="text/css">
            BODY, TD {font-family: verdana; font-size: 10pt; color: white}
        </style>
    </head>

    <body bgcolor=black link=red vlink=red alink=red>

    <center><font size=4>Envio de Foto</font><BR>
        <?php
        // Imagem foi enviada com sucesso, mostra mensagem de SUCESSO
        if ($arquivo && !sizeof($erro)) {
            echo "<img src=\"" . $imagem_dir . "\" border=0><BR><BR>Sua foto foi enviada com sucesso!<br>Deseja enviar outra? <a href=\"foto.php\">Clique aqui</a>";
        }

        // Ocorreu algum erro ou ainda o formul�rio n�o foi postado
        else {
            ?>
            <form action="<?echo $PHP_SELF?>" method=post  ENCTYPE="multipart/form-data">
                Envie sua foto em formato gif, jpg, bmp ou png.<BR>
                A imagem n�o deve ter mais que <?echo $config["tamanho"] ?> bytes e deve ter <? echo $config["largura"] . "x" . $config["altura"] ?> pixels.<BR>
                <table border=0 cellpadding=2 cellspacing=1 align=center>
                    <?php
                    if (sizeof($erro)) {
                        echo "<tr><td colspan=2 bgcolor=red><B><U>Ocorreu(am) o(s) seguinte(s) erro(s):</u><BR>";
                        foreach ($erro as $err) {
                            echo " - " . $err . "<BR>";
                        }
                        echo "</B></td></tr>";
                    }
                    ?>
                    <tr><td align=center>Enviar Foto: <input type=file size=30 name=foto></td></tr>
                    <tr><td align=center><input type=submit value="Ok!"></td></tr>
                </table>
            </form>
        <?php } ?>
        <br><font face=arial size=1 color=white>Programado por Alfred R. Baudisch - 14/01/2004. Vers�o 1.2</font>
    </body>
</html>