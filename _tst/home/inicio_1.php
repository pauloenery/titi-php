<!DOCTYPE html>
<html lang="pt_br">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../estilo/t3.css">
    <body>
        <div class="w3-row-padding" >
            <?php
            include("../phpfunction/userfunction.php");
            include('../home/menutopo.php');
            ?>


            <div class="w3-col w3-center w3-light-grey w3-card-8 w3-text-grey w3-margin-2 w3-background" style="background-image: url('../imagens/imagem-1.jpg'); height: 60%; cursor: pointer;" onclick="location.href = 'https://form.jotformz.com/60696054010650'">
                <table style="height: 40vw;">
                    <tr><td></td><td></td><td></td><td></td></tr>
                    <tr align="top">
                        <td width="5%"></td>

                        <td width="25%"></td>

                        <td width="30%"></td>

                        <td width="40%">
                            <a href="https://form.jotformz.com/60696054010650"> <img src="../imagens/home_pesquisa.jpg" alt=""  width="50%"/></a>

                        </td>

                    </tr>
                    <tr><td></td><td></td><td></td><td></td></tr>
                </table>
            </div>
            <?php include('../home/rodape.php'); ?>
        </div> 

        <?php
        if (file_exists("../home/mensagem.html")) {
            echo '<script>';
            echo 'window.open("../home/mensagem.html", "_blank", "toolbar=no,status=no,scrollbars=no,resizable=no,top=200,left=500,width=400,height=550");';
            echo '</script>';
        }
        ?>

    </body>
</html>
