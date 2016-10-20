<?php

function perfilespecialista($perfilespecialista) {
    if ($perfilespecialista == 2) {
        return 'Pediatria';
    } elseif ($perfilespecialista == 4) {
        return 'Adulto';
    } elseif ($perfilespecialista == 5) {
        return 'Idoso';
    }
}

function habilidade($habilidade) {
    if ($habilidade == 3) {
        return 'Alta Complexidade';
    } elseif ($habilidade == 2) {
        return 'Média Complexidade';
    } elseif ($habilidade == 1) {
        return 'Baixa Complexidade';
    }
}

function ativo($ativo) {
    if ($ativo == 1) {
        return "Desativar";
    } else {
        return "Ativar";
    }
}

function no_ativo($ativo) {
    if ($ativo == 1) {
        return 0;
    } else {
        return 1;
    }
}

function cargo($cargo) {

    if ($cargo == "1") {
        return 'Auxiliar/Técnico enfermagem';
    } else if ($cargo == "2") {
        return 'Enfermeiro';
    } else if ($cargo == "3") {
        return 'Cuidador';
    } else if ($cargo == "4") {
        return 'Fisioterapeuta';
    } else if ($cargo == "5") {
        return 'Fonoaudiólogo';
    } else {
        return 'Não informado';
    }
}

function periodo($periodo) {

    if ($periodo == "1") {
        return 'Diurno';
    } else if ($periodo == "2") {
        return 'Noturno';
    } else {
        return 'Não informado';
    }
}

function nome($nome) {

    $pos = stripos($nome, " ");

    if ($pos === false) {
        return $nome;
    } else {
        return substr($nome, 0, $pos);
    }
}

function setuser($user) {
    $cookie_name = "user";
    $cookie_value = $user;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}

function setusername($username) {
    $cookie_name = "username";
    $cookie_value = $username;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}

function setperfil($perfil) {
    $cookie_name = "perfil";
    $cookie_value = $perfil;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}

function unsetuser() {
    $cookie_name = "user";
    $cookie_value = "";
    setcookie($cookie_name, $cookie_value, time() - 3600, "/");
}

function unsetusername() {
    $cookie_name = "username";
    $cookie_value = "";
    setcookie($cookie_name, $cookie_value, time() - 3600, "/");
}

function unsetperfil() {
    $cookie_name = "perfil";
    $cookie_value = "";
    setcookie($cookie_name, $cookie_value, time() - 3600, "/");
}

function checkuser() {
    $cookie_name = "user";
    $checkuser = "";
    if (isset($_COOKIE[$cookie_name])) {
        $checkuser = $_COOKIE[$cookie_name];
    }
    return $checkuser;
}

function checkusername() {
    $cookie_name = "username";
    $checkusername = "";
    if (isset($_COOKIE[$cookie_name])) {
        $checkusername = $_COOKIE[$cookie_name];
    }
    return $checkusername;
}

function checkperfil() {
    $cookie_name = "perfil";
    $checkperfil = "";
    if (isset($_COOKIE[$cookie_name])) {
        $checkperfil = $_COOKIE[$cookie_name];
    }
    return $checkperfil;
}

?>