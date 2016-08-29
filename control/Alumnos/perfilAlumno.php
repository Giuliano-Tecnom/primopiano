<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/includes/functions.php';
$twigParams = array();
secure('perfilAlumno');
$twigParams["title"]= 'Bienvenido';



if(isset ($_POST['idUsuario'])){
    // Si se edito un usuario 
    if( (!empty($_POST['idUsuario'])) ){
        // Si completo los campos obligatorios
        print_r('entre');
        require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Usuario.php';
        $user = Usuario::fromId(intval($_POST['idUsuario']));

        if(!empty($_POST['nombreCompleto'])){
            $user->setNombreCompleto(trim($_POST['nombreCompleto']));
        }
        if (!empty($_POST['apellido'])){
            $user->setApellido(trim($_POST['apellido']));
        }
        if (!empty($_POST['email'])){
            $user->setEmail(trim($_POST['email']));
        }
        if (!empty($_POST['cantSemanal'])){
            $user->setCantidadSemanal(trim($_POST['cantSemanal']));
        }
        if (!empty($_POST['celular'])){
            $user->setCelular(trim($_POST['celular']));
        }
        $update = $user->updateUsuario();
        if($update){
            $twigParams['successMsg'] = "Se ha actualizado el usuario correctamente";
        }else{
            $twigParams['errorMsg'] = "Error al actualizar el usuario";
        }
        include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Usuario.php';
        $user = Usuario::fromId($_SESSION['idUsuario']);
        if(!$user){
            $twigParams["errorMsg"] = "El usuario no existe";
        }else{
            $twigParams['usuario'] =  trim($user->getNombre());
            $twigParams['nombreCompleto'] =  trim($user->getNombreCompleto());
            $twigParams['apellido'] =  trim($user->getApellido());
            $twigParams['cantSemanal'] =  trim($user->getCantidadSemanal());
            $twigParams['celular'] = trim($user->getCelular());
            $twigParams['email'] =  trim($user->getEmail());
            $twigParams['idUsuario'] =  trim($user->getIdUsuario());
            init('perfilAlumno.twig', $twigParams);
            exit();
        }
        init('perfilAlumno.twig', $twigParams);
        exit();
    }
}else{
        include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Usuario.php';
        $user = Usuario::fromId($_SESSION['idUsuario']);
        if(!$user){
            $twigParams["errorMsg"] = "El usuario no existe";
        }else{
            $twigParams['usuario'] =  trim($user->getNombre());
            $twigParams['nombreCompleto'] =  trim($user->getNombreCompleto());
            $twigParams['apellido'] =  trim($user->getApellido());
            $twigParams['cantSemanal'] =  trim($user->getCantidadSemanal());
            $twigParams['celular'] = trim($user->getCelular());
            $twigParams['email'] =  trim($user->getEmail());
            $twigParams['idUsuario'] =  trim($user->getIdUsuario());
            init('perfilAlumno.twig', $twigParams);
            exit();
        }
    }
