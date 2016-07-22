<?php

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