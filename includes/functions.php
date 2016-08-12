<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/lib/Twig/Autoloader.php';

//require_once './lib/Twig/Autoloader.php';
    

function init($template,$valores){
    
    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'].'/primopiano/templates');
    $twig = new Twig_Environment($loader, array(
    ));

    $template = $twig->loadTemplate($template);
    
    $template->display($valores);
}
function get_real_ip()
    {
 
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }
 
    }




function createSession($idUsuario,$usuario,$idPerfil){

	$_SESSION['usuario'] = $usuario;
	$_SESSION['idUsuario'] = $idUsuario;
	$_SESSION['idPerfil'] = $idPerfil;
    $_SESSION['ip'] = get_real_ip();
    $_SESSION['id'] = session_id();


}

function isValidIpAndSessionId(){

    if (($_SESSION['id'] !== session_id() ) || ( $_SESSION['ip'] !== get_real_ip() )){
        return false;
    }
    return true;


}

function closeSession(){
	session_destroy();
}

function redireccionarUsuario($idPerfil){
    switch ($idPerfil) {
            case "1":
                header('Location: ./control/Admin/indexAdmin.php');
                break;
            case "2":
                header('Location: ./control/Internos/indexInternos.php');
                break;
            case "3":
                header('Location: ./control/Externos/indexExternos.php');
                break;
        }
}

function secure($archivo,$login=false){
    if(isset($_SESSION['idUsuario'])&&$login){
        redireccionarUsuario($_SESSION['idPerfil']);
    }elseif(isset($_SESSION['idUsuario'])){
        include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Usuario.php';
        include_once $_SERVER['DOCUMENT_ROOT'].'/primopiano/model/Privilegios.php';
        
        $user = Usuario::fromId($_SESSION['idUsuario']);
        $privileges = $user->getPrivilegios()->getArchivos();
        if(!in_array($archivo, $privileges)){
            init('notalowed.twig', array(
            "title" => 'No posee permisos',
            "errorMsg" => 'Su usuario no posee permisos para acceder a esta pagina'
            ));
            exit();
        }
        global $twigParams;
        $twigParams['userPrivileges'] = $user->getPrivilegios()->getPrivilegios();
        $twigParams['archivo'] = $archivo;
        $twigParams['username'] = $user->getNombre();
    }else{
        if(!$login){
            header("Location: /index.php");
        }
    }
}


