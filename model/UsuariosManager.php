<?php

include_once 'database.php';
$database=new databasePDO();

class UsuariosManager {
    private $usuarios;

    // Constructor de Usuarios manager, por defecto carga los ultimos 15 usuarios
    function __construct($idPerfil='',$from=0,$to=1000) {
       $this->cargarDatos($from,$to,$idPerfil);
        
    }
    
    public static function fromId($idPerfil){
        $users = new UsuariosManager($idPerfil,0,0);
        return $users;
    }    
     
    

    private function cargarDatos($from,$to,$idPerfil){
        global $database;
        if(empty($idPerfil)){
            $resultado = $database->execute("SELECT * FROM usuario LIMIT $from,$to");
        }else{
            $resultado = $database->execute("SELECT * FROM usuario WHERE idPerfil=:idPerfil",array('idPerfil'=>$idPerfil));
        }
        
        $this->setUsuarios($resultado);
    }
	
    //-----------------------------getter y setter----------------------------------
    public function getUsuarios() {
        return $this->usuarios;
    }

    public function setUsuarios($usuarios) {
        $this->usuarios = $usuarios;
    }
	
}
