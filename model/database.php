<?php

/**
 * This class makes queries and connect to mysql db
 *

 */
class databasePDO {

    // objeto para pdo
    private $pdo;

    # query de pdo
    private $queryPDO;

    # estado de conexion
    private $conexion = false;

    # array de parametros
    private $parametros;

    # modo debug
    private $debug;

    public function __construct($debug = false) {
        $this->Connect();
        $this->parametros = array();
        $this->debug = $debug;
    }

    //conexion
    private function Connect() {
        try {
            // crea la conexion
            $this->pdo = new PDO('mysql:host=localhost;dbname=s4000464_olmos', 'grupo_1', '');

            // activo los errores por excepcion
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // activo el uso de prepared statements real
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


            $this->conexion = true;
        } catch (PDOException $e) {
            
                echo '<div class="errorBd">'.$e.'</div>';
                //echo "Error de conexion a la base de datos";
            die();
        }
    }

    // metodo que carga los parametros y ejecuta las consultas
    private function Init($query, $parameters = "") {
        // si no estoy conectado, conecta
        if (!$this->conexion) {
            $this->Connect();
        }
        try {
            // prepare de la prepare statement
            $this->queryPDO = $this->pdo->prepare($query);

            // agrego al arreglo los parametros que recibo 
            $this->bindMore($parameters);

            // bindeo los parametros a la query
            if (!empty($this->parametros)) {
                foreach ($this->parametros as $param) {
                    $parameters = explode("\x7F", $param);
                    $this->queryPDO->bindParam($parameters[0], $parameters[1]);
                }
            }

            // ejecuto la consulta
            $this->queryPDO->execute();
        } catch (PDOException $e) {
                echo '<div class="errorBd">'.$e.'</div>';
                //echo "Error al ejecutar la consulta";
            die();
        }

        // pongo los parametros en blanco de nuevo
        $this->parametros = array();
    }

    // metodo para agregar un parametros al arreglo de parametros
    public function bind($para, $value) {
        $this->parametros[sizeof($this->parametros)] = ":" . $para . "\x7F" . $value;
    }

    // metodo para agregar muchso parametros al arreglo de parametros
    public function bindMore($parray) {
        if (empty($this->parametros) && is_array($parray)) {
            $columns = array_keys($parray);
            foreach ($columns as $i => &$column) {
                $this->bind($column, $parray[$column]);
            }
        }
    }

    // metodo para ejecutar querys, devuelve cantidad de filas afectadas en
    // los update, insert y delete y los datos en el select
    public function execute($query, $params = null) {
        $query = trim($query);

        $this->Init($query, $params);

        if (stripos($query, 'select') === 0) {
            return $this->queryPDO->fetchAll(PDO::FETCH_ASSOC);
        } elseif (stripos($query, 'insert') === 0 || stripos($query, 'update') === 0 || stripos($query, 'delete') === 0) {
            return $this->queryPDO->rowCount();
        } else {
            return NULL;
        }
    }
    
    public function count(){
        if($this->queryPDO){
            return $this->queryPDO->rowCount();
        }else{
            return null;
        }
        
    }

    // devuelve el ultimo id insertado
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    // ejecuta una consulta y devuelve una fila
    public function row($query, $params = null) {
        $this->Init($query, $params);
        return $this->queryPDO->fetch(PDO::FETCH_ASSOC);
    }

}

?>
