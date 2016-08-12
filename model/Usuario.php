<?php

include_once 'database.php';
$database=new databasePDO();

class Usuario{
    private $nombre;
    private $idUsuario;
    private $pass;
    private $idPerfil;
    private $privilegios;
    
    
    // <editor-fold defaultstate="collapsed" desc="constructores">
    function __construct($idUsuario,$nombre,$pass,$idPerfil) {
        $this->nombre=$nombre;
        $this->idPerfil=$idPerfil;
        $this->pass=$pass;
        $this->idUsuario=$idUsuario;
        $this->cargarPrivilegios();
    }

    public static function login($usuario, $pass) {
        global $database;
        if ((!empty($usuario)) && (!empty($pass))) {

            $resultado = $database->row("SELECT idUsuario,nombre,CAST(MD5(pass) AS CHAR (500)) as pass,idPerfil FROM usuario WHERE nombre= :nombre and pass= MD5('".$pass."')", array("nombre" => $usuario));

            if ($resultado!= false) {
                $user = new Usuario($resultado["idUsuario"], $resultado["nombre"], $resultado["pass"], $resultado["idPerfil"]);
                return $user;
            } else {
                return null;
            }
        } else
            return null;
    }

    public static function fromId($idUsuario){
        global $database;
        $database=new databasePDO();
        $resultado= $database->row("SELECT idUsuario,nombre,CAST(MD5(pass) AS CHAR (500)) as pass,idPerfil FROM usuario WHERE idUsuario= :id",array("id"=>$idUsuario));
        if($resultado){
            return new Usuario($resultado["idUsuario"], $resultado["nombre"], $resultado["pass"], $resultado["idPerfil"]);
        }else{
            return null;
        }
    }
    
    public static function exists($name){
        global $database;
        $database=new databasePDO();
        $resultado= $database->execute("SELECT idUsuario,nombre,CAST(MD5(pass) AS CHAR (500)) as pass,idPerfil FROM usuario WHERE nombre=:nom",array("nom"=>$name));
        return $resultado;
    }
   //</editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="setter y getter">
    public function getNombre() {
        return $this->nombre;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getPass() {
        return $this->pass;
    }

    public function getIdPerfil() {
        return $this->idPerfil;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getPrivilegios() {
        return $this->privilegios;
    }

    public function setPrivilegios($privilegios) {
        $this->privilegios = $privilegios;
    }

        public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }
    //</editor-fold>

    // <editor-fold defaultstate="collapsed" desc="update - create - delete">
    public function updateUsuario() {
        global $database;
        $resultado = $database->execute("UPDATE usuario SET nombre= :nombre"
                . ",pass = MD5(\"".$this->pass."\")"
                . ",idPerfil = :idPerfil WHERE idUsuario = :idUsuario",
                array("nombre"=>  $this->nombre,"idPerfil"=> $this->idPerfil,"idUsuario"=>  $this->idUsuario));
        return $resultado;
    }
    
     public static function create($idPerfil,$nombre,$pass) {
        global $database;
        $result = $database->row("SELECT idUsuario,nombre,CAST(MD5(pass) AS CHAR (500)) as pass,idPerfil FROM usuario WHERE nombre=:nom",array("nom"=>$nombre));
        if(!$result){
            $resultado = $database->execute("INSERT INTO usuario (nombre,pass,idPerfil) values (:nombre, MD5(\"".$pass."\"),:idPerfil)", array("nombre" => $nombre , "idPerfil"=> $idPerfil));
            return $resultado;
        }else{
            return null;
        }        
    }
    
    
    public static function delete($id) {
        global $database;
        $resultado = $database->execute("Delete from usuario where idUsuario = :idUsuario ", array("idUsuario" => $id));
        return $resultado;
    }
    //</editor-fold>

   

    private function cargarPrivilegios(){
        require_once $_SERVER['DOCUMENT_ROOT'].'/frlisandroolmos/model/Privilegios.php';
        $this->setPrivilegios(new Privilegios($this->idPerfil));
    }
    
    
    
    
    
}