<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/includes/functions.php';
$twigParams = array();
secure('perfilAlumno');
$twigParams["title"]= 'Bienvenido';

include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Usuario.php';
$user = Usuario::fromId($_SESSION['idUsuario']);
    if(!$user){
        $twigParams["errorMsg"] = "El usuario no existe";
    }else{
        $twigParams['usuario'] =  $user->getNombre();
        $twigParams['nombreCompleto'] =  $user->getNombreCompleto();
        $twigParams['apellido'] =  $user->getApellido();
        $twigParams['cantSemanal'] =  $user->getCantidadSemanal();
        $twigParams['celular'] = $user->getCelular();
        $twigParams['email'] =  $user->getEmail();
        init('perfilAlumno.twig', $twigParams);
        exit();
    }

