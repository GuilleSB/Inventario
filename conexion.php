<?php
$hostname= "#";
$database = "#";
$userbd= "#";
$password = "#";
$port= "#";

$mysql = new mysqli($hostname, $userbd, $password, $database, $port);

if($mysql->connect_errno){
    echo "Se generaron problemas al realizar la conexión";
}
