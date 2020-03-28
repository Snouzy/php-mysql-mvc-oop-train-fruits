<?php
require_once('../common/db.infos.php');

class monPDO{
    private const HOST_NAME = dbInfos::HOST_NAME;
    private const DB_NAME = dbInfos::DB_NAME;
    private const USER_NAME = dbInfos::USER_NAME;
    private const PWD = dbInfos::PWD;

    private static $monPDOinstance = null;

    public static function getPDO(){
        if(is_null(self::$monPDOinstance)){
            try {
                $connexion = 'mysql:host='.self::HOST_NAME.';dbname='.self::DB_NAME;
                self::$monPDOinstance = new PDO($connexion,self::USER_NAME,self::PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch(PDOException $e){
                $message = "erreur de connexion à la DB". $e->getMessage();
                die($message);
            }
            self::$monPDOinstance->exec("SET CHARACTER SET UTF8");
        }
        return self::$monPDOinstance;
    }
}






?>