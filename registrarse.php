<?php

include_once './includes/functions.php';
secure('',true);

if((isset ($_POST['nombreUsuario']))&&(!(isset ($_POST['idUsuario'])))){
    // Si recibo nombre y el id es porque completaron el formulario para agregar un usuario
    if((!empty($_POST['nombreUsuario']))&&(!empty($_POST['pass']))&&(!empty($_POST['passR']))){
        // Si completaron todos los campos
        if($_POST['pass']!=$_POST['passR']){
            // Si las claves no coinciden
            require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/PerfilesManager.php';
            $perfiles = new PerfilesManager();
            $twigParams["profiles"] = $perfiles->getPerfiles();
            $twigParams["nombreUsuario"]= $_POST['nombreUsuario'];
            $twigParams["errorMsg"] = 'Las claves no coinciden';
            $twigParams["title"] = 'Nuevo Usuario - Error';
            init('AgregarUsuario.twig', $twigParams);
            exit();
        }
        require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Usuario.php';
        if(!Usuario::exists($_POST['nombreUsuario'])){
            if(Usuario::create(3, $_POST['nombreUsuario'], $_POST['pass'], $_POST['nombreCompleto'], $_POST['apellido'], $_POST['email'], $_POST['cantSemanal'], $_POST['celular'])){
                $twigParams["successMsg"] = "El usuario se ha creado correctamente";
            }else{
                $twigParams["errorMsg"] = "El usuario no se ha podido crear";
            }
        }else{
            $twigParams["errorMsg"] = "Ya existe un usuario con ese nombre";
        }
        
    }else{
        $twigParams["errorMsg"] = "Se deben completar todos los campos";
    }
}

$twigParams["title"] = 'Registrarse';
init('registrarse.twig', $twigParams);