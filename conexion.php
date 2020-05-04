<?php
$hostname= "localhost";
$database = "3406236_guatusodev";
$userbd= "root";
$password = "";
$port= "3308";

$mysql = new mysqli($hostname, $userbd, $password, $database, $port);

if($mysql->connect_errno){
    echo "Se generaron problemas al realizar la conexión";
}