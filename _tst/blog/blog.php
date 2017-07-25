<!DOCTYPE html>
<html lang="en" >

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
        <TITLE>TITI - Cuidadores cuidadosos</TITLE>
        <META NAME="DESCRIPTION" CONTENT="Sabe o amor que você sente por uma pessoa? A gente sabe. Encontre Cuidadores, Enfermeiras e Fisioterapeutaas  para cuidar de quem você ama.">
        <META NAME="ABSTRACT" CONTENT="Sabe o amor que você sente por uma pessoa? A gente sabe.">
        <META NAME="KEYWORDS" CONTENT="Cuidadores, Cuidador, Idosos, Lar, Cuidados, Pessoas Especiais, Deficientes, Cuidador de Idoso, Deficientes, Cuidadores de Idosos, Cuidadores de Pessoas com Deficiência, Encontrar Cuidador, Buscador, Encontre Cuidadores, Buscar, Buscar Cuidador, Zona Leste, Zona Sul, Zona Oeste, Cuidador Zona Norte, Cuidador de Idosos em São Paulo, Cuidadores SP, cuidadores de idosos, assistência ao idoso hospitalizado, cuidador de bebe, cuidador de criança, cuidador de crianças, cuidador de deficientes, cuidador de idosos, cuidador especial, cuidadora, cuidadores, cuidadores de criança com deficiencia, cuidadores de idosos, cuidadores de pessoas, cuidadores de pessoas com alzheimer, cuidadores de pessoas com avc, cuidadores de pessoas com deficiencia atendidas em casa, cuidadores de pessoas com deficiencias, cuidadores de pessoas com necessidades especiais, cuidadores no lar, cuidados com paciente acamado, cuidados de pessoas idosas, cuidar de pessoas, cuidar de pessoas com alzheimer, cuidar de pessoas doentes, cuidar de pessoas idosas, cuidar de pessoas idosas acamadas, idoso acamado, idoso acamado com avc, fisioterapia, idosos, paciente acamado, paciente acamado cuidados, profissional cuidador, profissional cuidador de idoso, profissional cuidador de idosos">
        <META NAME="ROBOT" CONTENT="All">
        <META NAME="RATING" CONTENT="general">
        <META NAME="DISTRIBUTION" CONTENT="global">
        <meta http-equiv="content-language" content="pt-br" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta name="keywords" content="Cuidadores, Cuidador, Idosos, Lar, Cuidados, Pessoas Especiais, Deficientes, Cuidador de Idoso, Deficientes, Cuidadores de Idosos, Cuidadores de Pessoas com Deficiência, Encontrar Cuidador, Buscador, Encontre Cuidadores, Buscar, Buscar Cuidador, Zona Leste, Zona Sul, Zona Oeste, Cuidador Zona Norte, Cuidador de Idosos em São Paulo, Cuidadores SP, cuidadores de idosos, assistência ao idoso hospitalizado, cuidador de bebe, cuidador de criança, cuidador de crianças, cuidador de deficientes, cuidador de idosos, cuidador especial, cuidadora, cuidadores, cuidadores de criança com deficiencia, cuidadores de idosos, cuidadores de pessoas, cuidadores de pessoas com alzheimer, cuidadores de pessoas com avc, cuidadores de pessoas com deficiencia atendidas em casa, cuidadores de pessoas com deficiencias, cuidadores de pessoas com necessidades especiais, cuidadores no lar, cuidados com paciente acamado, cuidados de pessoas idosas, cuidar de pessoas, cuidar de pessoas com alzheimer, cuidar de pessoas doentes, cuidar de pessoas idosas, cuidar de pessoas idosas acamadas, idoso acamado, idoso acamado com avc, fisioterapia, idosos, paciente acamado, paciente acamado cuidados, profissional cuidador, profissional cuidador de idoso, profissional cuidador de idosos" />

        <!-- CSS  -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Oleo+Script:400,700&subset=latin-ext" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="t3.css" />
        <link rel="stylesheet" href="blog.css" />
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })
                    (window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            /*ga('create', 'UA-84850577-1', 'none');*/
            ga('create', 'UA-84850577-1');
            /*ga('send', 'pageview');*/

        </script>

        <!-- Google Tag Manager -->
        <script>
            function myFunction() { 
                var z = 250;
                var x = document.getElementById("Img").width;
                var y = document.getElementById("Img").height;
                var w = z / x;
                document.getElementById("Img").width = x * w;
                document.getElementById("Img").height = y * w;
            }
            function myFunction2(star) {
                document.getElementById(star).checked = "yes";
            }

        </script>

    </head>
    <body>

        <?php
        include "buscadados.php";
        ?>
        <div class="w3-row-padding" >

            <div class="w3-col m2"></div>

            <div id="content" class="w3-card-4 w3-col m8" style="padding: 0px;">
                <header class="w3-container w3-center w3-grey">
                    <?php
                    echo "<h1>" . $retorno[0]["nome"] . "</h1>";
                    ?>
                </header>
                <hr />
                <div class="w3-row section">
                    <?php
                    if ($retorno[0]["foto"] <> "") {
                        echo '<img id="Img" src="data:image/png;base64,' . $retorno[0]["foto"] . '"/>';
                    } else {
                        echo '<img src="../../../titi-website/assets/images/profile_default.png"/>';
                    }
                    echo '<br>';
                    ?>
                    <script>
                        myFunction();
                    </script>
                </div>


                <div class="w3-row section">
                    <h4>Informações pessoais</h4>
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Nome</span>
                    <input class="w3-col m6 s7 w3-input" type="text" id="name" disabled size="50" maxlength="50" value="<?php echo $retorno[0]["nome"]; ?>">
                </div>

                <div class="w3-row question">
                    <span class="w3-col m4 s4">Data de nascimento</span>
                    <input class="w3-col m3 s7 w3-input" type="date" id="date" disabled value="<?php echo $retorno[0]["nascimento"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Telefone</span>
                    <input class="w3-col m2 s7 w3-input" type="text" id="tel" disabled value="<?php echo $retorno[0]["tel"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Celular</span>
                    <input class="w3-col m2 s7 w3-input" type="text" id="cel" disabled value="<?php echo $retorno[0]["cel"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">E-mail</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="email" disabled value="<?php echo $retorno[0]["email"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">CPF</span>
                    <input class="w3-col m2 s7 w3-input" type="text" id="cpf" disabled value="<?php echo $retorno[0]["cpf_cnpj"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">RG</span>
                    <input class="w3-col m2 s7 w3-input" type="text" id="rg" disabled value="<?php echo $retorno[0]["rg"]; ?>">
                </div>
                <hr />

                <div class="w3-row section">
                    <h4>Informações residenciais</h4>
                </div>
<!--
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Endereço</span>
                    <input class="w3-col m5 s7 w3-input" type="text" id="endereco" disabled value="<?php echo $retorno[0]["endereco"]; ?>">
                </div>
-->
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Bairro</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="bairro" disabled value="<?php echo $retorno[0]["bairro"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">CEP</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="cep" disabled value="<?php echo $retorno[0]["cep"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Cidade</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="cidade" disabled value="<?php echo $retorno[0]["cidade"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Estado</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="estado" disabled value="<?php echo $retorno[0]["estado"]; ?>">
                </div>
                <hr />

                <div class="w3-row section">
                    <h4>Experiência profissional</h4>
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Orgão Emissor</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="orgaoemissor" disabled value="<?php echo $retorno[0]["orgaoemissor"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Ano Registro</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="registro" disabled value="<?php echo $retorno[0]["registro"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Número de Registro</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="nr_identificacao" disabled value="<?php echo $retorno[0]["nr_identificacao"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Estado</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="UF" disabled value="<?php echo $retorno[0]["UF"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Área de atuação</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="atuacao" disabled value="<?php echo $retorno[0]["atuacao"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Período de preferência</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="periodo" disabled value="<?php echo $retorno[0]["periodo"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Perfil preferido de pacientes</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="perfilespecialista" disabled value="<?php echo $retorno[0]["perfilespecialista"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Nível habilidade com pacientes</span>
                    <input class="w3-col m3 s7 w3-input" type="text" id="habilidade" disabled value="<?php echo $retorno[0]["habilidade"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Experiência</span>
                    <textarea class="w3-col m5 s7 w3-input" rows="4" cols="50" size="50" maxlength="200" name="experiencia" id="experiencia" disabled value=""><?php echo $retorno[0]["experiencia"]; ?></textarea>

                </div>
                <!--                
                                <div class="w3-row question">
                                    <span class="w3-col m4 s4">minicv</span>
                                    <input class="w3-col m3 s7 w3-input" type="text" id="minicv" disabled value="<?php echo $retorno[0]["minicv"]; ?>">
                                </div>
                -->
                <div class="w3-row question">
                    <span class="w3-col m4 s4">Disponível para início imediato</span>
                    <input class="w3-col m1 s7 w3-input" type="text" id="disponibilidade" disabled value="<?php echo $retorno[0]["disponibilidade"]; ?>">
                </div>
                <div class="w3-row question">
                    <span class="w3-col m3 s4">Avaliação Geral</span>

                    <div class="rating rating-wrapper w3-col m5 s10">
                        <input type="radio" id="star5" disabled name="rating" value="5"   />
                        <label class="full" for="star5" title="Muito satisfeito"></label>

                        <input type="radio" id="star4" disabled name="rating" value="4" />
                        <label class="full" for="star4" title="Satisfeito"></label>

                        <input type="radio" id="star3" disabled name="rating" value="3" />
                        <label class="full" for="star3" title="Parcialmente"></label>

                        <input type="radio" id="star2" disabled name="rating" value="2" />
                        <label class="full" for="star2" title="Insatisfeito"></label>

                        <input type="radio" id="star1" disabled name="rating" value="1" />
                        <label class="full" for="star1" title="Muito insatisfeito"></label>
                    </div>
                    <span class="w3-col m2 s2">
                        <?php echo $retorno[0]["classificacao"] . '<br>' . $retorno[0]["total"] . '-'; ?>total
                    </span>
                </div>
                <hr />
                <?php
                $class = $retorno[0]["classificacao"];
                if ($class > 0.5 && $class <= 1.5) {
                    $star = "star1";
                }
                if ($class > 1.5 && $class <= 2.5) {
                    $star = "star2";
                }
                if ($class > 2.5 && $class <= 3.5) {
                    $star = "star3";
                }
                if ($class > 3.5 && $class <= 4.5) {
                    $star = "star4";
                }
                if ($class > 4.5 && $class <= 5) {
                    $star = "star5";
                }
                ?>
                <script>
                    myFunction2('<?php echo $star; ?>');
                </script>

                <?php
                include "avaliacoes.php";
                ?>
            </div>
        </div>
    </body>
</html>
