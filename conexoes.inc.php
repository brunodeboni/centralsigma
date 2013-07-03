<?php

class Database extends PDO {
 
    private static $instancia;
 
    public function Database($dsn, $username, $password, $attr) {
        // O construtor abaixo é o do PDO
         parent::__construct($dsn, $username, $password, $attr);
    }
 
    public static function instance($db_name) {
        // Se a instancia não existe eu faço uma
        
        if(!isset( self::$instancia )){
        	try {
            	self::$instancia = new Database(
                	'mysql:host=mysql.centralsigma.com.br;dbname='.$db_name, 
                	'webadmin', 'webADMIN', 
                	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
                self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch ( PDOException $e ) {
                echo 'PDO Exception: '.$e->getMessage();
            }
        }
        // Se já existe instancia na memória eu retorno ela
        return self::$instancia;
    }
}
?>