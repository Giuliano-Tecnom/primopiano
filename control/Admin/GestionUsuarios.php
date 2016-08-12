<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/includes/functions.php';

$twigParams = array();

secure('GestionUsuarios');

require_once $_SERVER['DOCUMENT_ROOT'] . '/primopiano/model/PerfilesManager.php';
$perfiles = new PerfilesManager();
$twigParams["profiles"] = $perfiles->getPerfiles();

// Si recivo add en 1 entro en AgregarUsuario
if (isset($_POST['addUser'])) {	
    $twigParams["title"] = 'Nuevo Usuario';
    init('AgregarUsuario.twig', $twigParams);
    exit();
}elseif(isset($_GET['modU'])){
    // Si recibo modU es modificar un usuario
    require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Usuario.php';
    $user = Usuario::fromId(intval($_GET['modU']));
    if(!$user){
        $twigParams["errorMsg"] = "El usuario no existe";
    }else{
        $twigParams['nombreUsuario'] =  $user->getNombre();
        $twigParams['idUsuario'] = $user->getIdUsuario();
        $twigParams['idPerfilM'] = $user->getIdPerfil();
        $twigParams["title"] = 'Modificar Usuario';
        init('ModificarUsuario.twig', $twigParams);
        exit();
    }
}elseif((isset ($_POST['nombreUsuario']))&&(!(isset ($_POST['idUsuario'])))){
    // Si recibo nombre y el id es porque completaron el formulario para agregar un usuario
    if((!empty($_POST['nombreUsuario']))&&(!empty($_POST['pass']))&&(!empty($_POST['passR']))&&(!empty($_POST['idPerfil']))){
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
            if(Usuario::create($_POST['idPerfil'], $_POST['nombreUsuario'], $_POST['pass'])){
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
}elseif(isset ($_POST['idUsuario'])){
    // Si se edito un usuario y se envio solo el idusuario
    if((!empty($_POST['nombreUsuario']))&&(!empty($_POST['idPerfil']))&&(!empty($_POST['idUsuario']))){
        // Si completo los campos obligatorios
        require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Usuario.php';
        $user = Usuario::fromId(intval($_POST['idUsuario']));
        if((!empty($_POST['pass']))&&(!empty($_POST['passR']))){
            // Cambiar clave    
            if($_POST['pass']!=$_POST['passR']){
                $twigParams['nombreUsuario'] =  $user->getNombre();
                $twigParams['idUsuario'] = $user->getIdUsuario();
                $twigParams['errorMsg'] = "Las claves no coinciden";
                $twigParams["title"] = 'Modificar Usuario - Error';
                init('ModificarUsuario.twig', $twigParams);
                exit();
            }else{
                $user->setPass($_POST['pass']);
            }
        }
        $user->setIdPerfil($_POST['idPerfil']);
        $user->setNombre($_POST['nombreUsuario']);
        $update = $user->updateUsuario();
        if($update){
            $twigParams['successMsg'] = "Se ha actualizado el usuario correctamente";
        }else{
            $twigParams['errorMsg'] = "Error al actualizar el usuario";
        }
    }
}
require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/UsuariosManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Privilegios.php';

// Si se quiere eliminar un usuario
if(isset($_GET['d'])){
    require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Usuario.php';
    if(Usuario::delete(intval($_GET['d']))){
        $twigParams["successMsg"] = "El usuario se ha eliminado correctamente";
    }else{
        $twigParams["errorMsg"] = "El usuario no se ha podido eliminar";
    }
}

$usuarios = new UsuariosManager();
$privilegios = new Privilegios();

$twigParams["title"] = 'Gestion de Usuarios';
$twigParams["users"] = $usuarios->getUsuarios();
$twigParams["privileges"] = $privilegios->getPrivilegios();
$twigParams["idUsuario"] = $_SESSION['idUsuario'];

init('GestionUsuarios.twig', $twigParams);