<?php
require_once "../config/Conection.php";
header("Content-type: application/json; charset=utf-8");
require_once "ramais.php";

use App\Lib\ApiRamais;

if(isset($_REQUEST['arrayNome']) && !empty($_REQUEST['arrayNome'])){
    $arrayNome = $_REQUEST['arrayNome'];
    $arrayOperador = $_REQUEST['arrayOperador'];
    $arrayStatus = $_REQUEST['arrayStatus'];
    $arrayOnline = $_REQUEST['arrayOnline'];
    $online = explode(',', $arrayOnline);
    $status = explode(',', $arrayStatus);
    $operador = explode(',', $arrayOperador);
    $nome = explode(',', $arrayNome);
    $var = 4;
    for($i = 0; $i <= $var; $i++){
        ApiRamais::updateRamais($nome[$i], $operador[$i]);
        ApiRamais::updateStatusRamais($nome[$i], $status[$i]);
        ApiRamais::updateOnlineRamais($nome[$i], $online[$i]);
    }
}