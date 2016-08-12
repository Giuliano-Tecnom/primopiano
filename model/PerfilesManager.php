<?php

include_once 'database.php';
$database=new databasePDO();

class PerfilesManager {
    
    private $perfiles;
    
    // Constructor de Perfiles manager
    function __construct() {
        $this->cargarDatos();
    }
    
    private function cargarDatos(){
        global $database;
        $resultado = $database->execute("SELECT * FROM perfil");
        $this->setPerfiles($resultado);
    }
	
    //-----------------------------getter y setter----------------------------------
    public function getPerfiles() {
        return $this->perfiles;
    }

    public function setPerfiles($perfiles) {
        $this->perfiles = $perfiles;
    }


}
