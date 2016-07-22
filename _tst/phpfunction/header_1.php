<?php

/*
  if($_SERVER['HTTP_ORIGIN'] == "http://titi.net.br")
  {
  header("Content-Type: application/json; charset=utf-8");
  header('Access-Control-Allow-Origin: http://titi.net.br');
  header('Access-Control-Allow-Headers: Origin, Content-Type');

  }
  else
  {
  header('Content-Type: text/html');
  echo "<html>";
  echo "<head>";
  echo "   <title>Mensagem</title>";
  echo "</head>";
  echo "<body>",
  "<p>Este recurso comporta-se de duas maneiras:";
  echo "<ul>",
  "<li>Se acessado de <code>http://titi.net.br</code> ele retorna documento JSON </li>";
  echo " <li>Se acessado a partir de qualquer outra origem, ou simplesmente digitando o URL na barra de endereços do navegador,";
  echo "você recebe esse documento HTML</li>",
  "</ul>",
  "</body>",
  "</html>";
  }
 */

header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-Type');
