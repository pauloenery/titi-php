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
            $atuacao = 0;
            ?>                            


            <div class="w3-col w3-center w3-light-grey w3-card-8 w3-text-grey w3-margin-2 w3-background" style="background-image: url('../imagens/imagem-1.jpg'); height: 47%; " >
                <form action="../relat/pesquisa_resumo.php" method="post" name="cadastro" id="cadastro"  onSubmit="return valida();">
                    <!--
                    <form action="../relat/enviar_pre-relatorio_profissional.php" method="post" name="cadastro" id="cadastro"  onSubmit="return valida();">
                    -->
                    <table style="height: 40vw">
                        <tr style="height: 20vw">
                            <td width="60%"></td>
                            <td width="35%" class="w3-left-align">
                                <img src="../imagens/home_pesquisa_1.jpg" alt=""  width="50%"/>

                                <h5 class="w3-text-dark-blue " >
                                    <?php

                                    function Selected($Selected, $Value) {
                                        echo ($Selected == $Value ? 'selected="selected"' : '');
                                    }
                                    ?>

                                    <select name="atuacao" id="atuacao" >
                                        <?php
                                        $profissionais = array(
                                            0 => 'Escolha o Profissional...',
                                            'Auxiliar/Técnico enfermagem',
                                            'Enfermeiro',
                                            'Cuidador',
                                            'Fisioterapeuta',
                                            'Fonoaudiólogo'
                                        );

                                        foreach ($profissionais as $key => $profissional):
                                            ?>
                                            <option <?php Selected($atuacao, $key); ?> value="<?php echo $key; ?>"><?php echo $profissional; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </h5>
                                <h5 class="w3-text-dark-blue " >
                                    <input name="cep" type="text" id="cep" size="17" maxlength="10" onKeyPress="MascaraCep(cadastro.cep);" value="" placeholder="Escolha seu CEP...">
                                </h5>
                                <img src="../imagens/home_pesquisa_2.jpg" alt=""  width="50%" onclick="submit()" style="cursor: pointer;"/>

                            </td>
                            <td width="5%"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <?php include('../home/rodape.php'); ?>
        </div> 
    </body>
</html>
