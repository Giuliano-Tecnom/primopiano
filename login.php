<?php

include_once './includes/functions.php';
include_once './model/Usuario.php';

secure('',true);

if (!empty($_POST['usuario']) and !empty($_POST['password'])) {

    $User = Usuario::login($_POST['usuario'], $_POST['password']);

    if ($User != null) {

        createSession($User->getIdUsuario(),$User->getNombre(),$User->getIdPerfil());

        redireccionarUsuario($User->getIdPerfil());
    } else {
        init('login.twig', array(
            "title" => 'Ingresar al Sistema',
            "errorMsg" => 'Usuario o clave incorrecta'
        ));
    }
} else {
    if((!empty($_POST['usuario']) or !empty($_POST['password']))){
        $errorMsg = 'Debe rellenar ambos campos';
    }else
        $errorMsg = '';
    init('login.twig', array(
        "title" => 'Ingresar al Sistema',
        "errorMsg" => $errorMsg
    ));
}
