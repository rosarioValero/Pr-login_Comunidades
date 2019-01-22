<?php

class Database {
    private static $instancia;
    public $con;

    private function __construct(){
        try {
            $this->con = new PDO('pgsql:host=localhost;dbname=daw2a_comunidades', 'postgres', '123456789');
            //$conexion = new PDO('pgsql:host=localhost;dbname=daw2a_comunidades', 'daw2a', 'abc123.');
        } catch (PDOException $e) {
            //throw $th;
            echo "Error: " . $e->getMessage();
        
        }
    }
    
	public static function makecon(){
        if (!isset(self::$instancia)) {
            # code...
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia->con;
        
    }
}

?>
