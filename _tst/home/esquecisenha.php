<!DOCTYPE html>
<html lang="pt_br">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../estilo/t3.css">
    <script src="../js/mascara.js" type="text/javascript"></script>
    <body class="w3-light-grey">
        <div class="w3-row-padding" >
            <?php
            include("../phpfunction/userfunction.php");
            include('../home/menutopo.php');
            ?>


            <div class="w3-col w3-center w3-light-grey w3-text-grey ">
                <h2>Já tenho cadastro</h2>
                <form action="../cadastro/trocarsenha.php" method="POST" name="trocarsenha" id="trocarsenha"  >
                    <table class="w3-center" style="height: 5vw" >
                        <tr>    
                            <td class="w3-right-align" width="40%">
                                <h3>e-mail:</h3>
                            </td>
                            <td class="w3-left-align" width="60%">
                                <h4><input name="email" type="text" id="email" size="25"></h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="w3-right-align">
                                <h4>Data de Nascimento:</h4>
                            </td>
                            <td class="w3-left-align">
                                <h4>
                                    <input name="nascimento" type="text" id="nascimento" size="10" maxlength="10" onKeyPress="MascaraData(trocarsenha.nascimento);">
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="w3-left-align">
                                <h4><input type="submit" value="Entrar" name="entrar"></h4>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>
