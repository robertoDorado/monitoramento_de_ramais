<?php
 namespace App\Lib;
 require_once "../config/Conection.php";
 header("refresh: 10");
/**
 * Você deverá transformar em uma classe
 */
use App\Config\Conection;

abstract class ApiRamais {

    public static $ramais; 
    public static $filas;
    public static $status_ramais; 
    public static $info_ramais;
    public static $info_operadores;

    public static function getOperadores(){
        self::$filas = file("filas");
        self::$info_operadores = array();

        $arrayFilterSIP = array_filter(self::$filas, function($item) {
            if(strstr($item, 'SIP/7000')){
                $operadores = str_replace(' ', '', strrchr(trim($item), ' '));
                self::$info_operadores['7000'] = array(
                    'operador' => $operadores
                );
            }
            if(strstr($item, 'SIP/7001')){
                $operadores = str_replace(' ', '', strrchr(trim($item), ' '));
                self::$info_operadores['7001'] = array(
                    'operador' => $operadores
                );
            }
            if(strstr($item, 'SIP/7002')){
                $operadores = str_replace(' ', '', strrchr(trim($item), ' '));
                self::$info_operadores['7002'] = array(
                    'operador' => $operadores
                );
            }
            if(strstr($item, 'SIP/7003')){
                $operadores = str_replace(' ', '', strrchr(trim($item), ' '));
                self::$info_operadores['7003'] = array(
                    'operador' => $operadores
                );
            }
            if(strstr($item, 'SIP/7004')){
                $operadores = str_replace(' ', '', strrchr(trim($item), ' '));
                self::$info_operadores['7004'] = array(
                    'operador' => $operadores
                );
            }
        });

        return self::$info_operadores;
    }

    public static function getStatus(){
        self::$filas = file("filas");
        self::$status_ramais = array();

        foreach(self::$filas as $linhas){

            if(strstr($linhas,'SIP/')){

                if(strstr($linhas,'(Ring)')){

                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal) = explode('/',$linha[0]);

                    self::$status_ramais[$ramal] = array('status' => 'chamando');
                }
                if(strstr($linhas,'(In use)')){    

                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal) = explode('/',$linha[0]);
                    self::$status_ramais[$ramal] = array('status' => 'ocupado');

                }
                if(strstr($linhas,'(Not in use)')){
                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal)  = explode('/',$linha[0]);
                    self::$status_ramais[$ramal] = array('status' => 'disponivel');

                }
                if(strstr($linhas,'(Unavailable)')){
                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal)  = explode('/',$linha[0]);
                    self::$status_ramais[$ramal] = array('status' => 'indisponivel');

                }
                if(strstr($linhas,'(paused)')){
                    $linha = explode(' ', trim($linhas));
                    list($tech,$ramal)  = explode('/',$linha[0]);
                    self::$status_ramais[$ramal] = array('status' => 'pausado');

                }

            }

        }
        
        return self::$status_ramais;
    }

    public static function getRamais($status_ramais, $arrayOperadores){
        self::$ramais = file("ramais");
        self::$info_ramais = array();

        foreach(self::$ramais as $linhas){

            $linha = array_filter(explode(' ',$linhas));

            $arr = array_values($linha);

            if(in_array('(Unspecified)', $arr)){

                if(trim($arr[1]) == '(Unspecified)' && trim($arr[4]) == 'UNKNOWN'){      
                    list($name,$username) = explode('/',$arr[0]);

                    self::$info_ramais[$name] = array(
                        'nome' => $name,
                        'ramal' => $username,
                        'operador' => $arrayOperadores[$name]['operador'],
                        'online' => false,
                        'status' => $status_ramais[$name]['status']
                    );     
                }
            }
            if(in_array("OK", $arr)){

                if(trim($arr[5]) == "OK"){  

                list($name,$username) = explode('/',$arr[0]);

                    self::$info_ramais[$name] = array(
                        'nome' => $name,
                        'ramal' => $username,
                        'operador' => $arrayOperadores[$name]['operador'],
                        'online' => true,
                        'status' => $status_ramais[$name]['status']
                    );

                }
            }
        }

        return self::$info_ramais;
    }

    public static function insertInfoRamais($nome, $ramal, $operador, $online, $status){
        $pdo = Conection::conectionMethod();
        
        if(self::countRamais()){
            if($online == ''){
                $online = 0;
                $sql = "INSERT INTO ramais (nome, ramal, operador, online_, status_) VALUES (:nome, :ramal, :operador, :online_, :status_)";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":ramal", $ramal);
                $sql->bindValue(":operador", $operador);
                $sql->bindValue(":online_", $online);
                $sql->bindValue(":status_", $status);
                $sql->execute();
                
                return true;
            }else{
                $sql = "INSERT INTO ramais (nome, ramal, operador, online_, status_) VALUES (:nome, :ramal, :operador, :online_, :status_)";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":ramal", $ramal);
                $sql->bindValue(":operador", $operador);
                $sql->bindValue(":online_", $online);
                $sql->bindValue(":status_", $status);
                $sql->execute();
                
                return true;
            }
            
        }
    }

    public static function updateRamais($nome, $operador){
        $pdo = Conection::conectionMethod();
        $sql = "UPDATE ramais SET operador = :operador WHERE nome = :nome";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":operador", $operador);
        $sql->execute();
    }

    public static function updateStatusRamais($nome, $status){
        $pdo = Conection::conectionMethod();
        $sql = "UPDATE ramais SET status_ = :status_ WHERE nome = :nome";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":status_", $status);
        $sql->bindValue(":nome", $nome);
        $sql->execute();
    }

    public static function updateOnlineRamais($nome, $online){
        $pdo = Conection::conectionMethod();
        $sql = "UPDATE ramais SET online_ = :online_ WHERE nome = :nome";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":online_", $online);
        $sql->bindValue(":nome", $nome);
        $sql->execute();
    }

    public static function getAllRamais(){
        $pdo = Conection::conectionMethod();
        $sql = "SELECT * FROM ramais";
        $sql = $pdo->query($sql);
        
        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }
    }

    private static function countRamais(){
        $total = 0;
        $pdo = Conection::conectionMethod();
        $sql = "SELECT COUNT(*) as c FROM ramais";
        $sql = $pdo->query($sql);
        $sql = $sql->fetch();
        $total = $sql['c'];

        if($total < 5){ 
            return true;
        }else{
            return false;
        }
    }
}
header("Content-type: application/json; charset=utf-8");
$arrayOperadores = ApiRamais::getOperadores();
$arrayStatusFilas = ApiRamais::getStatus();
$arrayRamais = ApiRamais::getRamais($arrayStatusFilas, $arrayOperadores);
foreach($arrayRamais as $infoRamal){
    ApiRamais::insertInfoRamais($infoRamal['nome'], $infoRamal['ramal'], $infoRamal['operador'], $infoRamal['online'], $infoRamal['status']);
}
echo json_encode($arrayRamais, JSON_UNESCAPED_UNICODE);