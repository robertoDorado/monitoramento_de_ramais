<?php
namespace App\Config;
use PDO;

abstract class Conection {

    protected static $pdo;

    public static function conectionMethod() {

        $host = '127.0.0.1';
        $dbName = 'monitoramento_ramais';
        $dbUser = 'root';
        $dbPass = '';

        try{
            self::$pdo = new PDO("mysql:dbname=" . $dbName . ";host=" . $host, $dbUser, $dbPass);
            return self::$pdo;
        }catch(PDOExceptio $e){
            echo "Erro: " . $e->getMessage();
        }
    }
}