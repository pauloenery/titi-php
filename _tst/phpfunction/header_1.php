<?php
/*
if ($_SERVER['HTTP_HOST'] == "titi.net.br") {
    header("Content-Type: application/json; charset=utf-8");
    header('Access-Control-Allow-Origin: http://titi.net.br');
    header('Access-Control-Allow-Headers: Origin, Content-Type');
} else {
    header('Content-Type: text/html');
    echo "<html>";
    echo "<head>";
    echo "<title>Mensagem</title>";
    echo "</head>";
    echo "<body>";
    echo "<p>Este recurso foi acessado de maneira ilegal:"
        . "<ul>"
        . "<li>Se acessado de <code>http://titi.net.br</code> ele retorna documento JSON </li>"
        . "<li>Se acessado a partir de qualquer outra origem, "
        . "ou simplesmente digitando o URL na barra de endereços do navegador, "
        . "você recebe esse documento HTML</li>"
        . "</ul>";
    echo "</body>";
    echo "</html>";

    exit('Programa abortado');
}
*/


header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-Type');
