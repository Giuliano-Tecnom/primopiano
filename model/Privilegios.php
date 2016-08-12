<?php

include_once  'database.php';
$database=new databasePDO();

class Privilegios {
    private $privilegios;
    
    function __construct($idPerfil="") {
        $this->cargarDatos($idPerfil);
    }
    
    private function cargarDatos($idPerfil){
        global $database;
        if(!empty($idPerfil)){
            $resultado = $database->execute("SELECT nombre,archivo FROM privilegio WHERE idPerfil=:idPerfil",array("idPerfil"=>$idPerfil));
            $arreglo  = array();
            foreach($resultado as $privilegio){
                $arreglo[count($arreglo)] = $privilegio;
            }
        }else{
            $resultado = $database->execute("SELECT * FROM privilegio");
            $arreglo = array(); 
            foreach($resultado as $privilegio){
                if(!(isset($arreglo[$privilegio["idPerfil"]]))){
                    $arreglo[$privilegio["idPerfil"]] = array();
                    
                }
                $arreglo[$privilegio["idPerfil"]][] = $privilegio;
                
            }
        }
        $this->privilegios=$arreglo;
    }
    
    public function getPrivilegios(){
        return $this->privilegios;
    }
    
    public function getArchivos(){
        //return array_column($this->getPrivilegios(),'archivo');
        //array_column($a, 'last_name');
       return  array_map(function($element){

        return $element['archivo'];
        } 
        , $this->getPrivilegios());

    }
}
