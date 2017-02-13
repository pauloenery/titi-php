<?php

function geralog($msg, $prg) {
    $file = '../log/TitiCuidadores.'.date("Y-m-d").'.log';
// $entityBody = file_get_contents('./contato.json', true);
// Open the file to get existing content
    $current = '';
// Append a new message to the file
    $current .= date("Y-m-d")." ".date("H:i:s")." - ".$prg.' - '.$msg.chr(10);
// Write the contents back to the file
    file_put_contents($file, $current, FILE_APPEND);
}
?>

