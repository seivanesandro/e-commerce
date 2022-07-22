<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$debug = true; //modo de debug

$server = 'localhost'; //IP 127.0.0.1:3306
$user = 'root';
$pw = '';
$bd = 'dbmind';



$conn = new mysqli($server, $user, $pw, $bd);

if ($conn->connect_error) {
        echo "Erro a ligar a base de dados: $conn->connect_error";
        exit;
} 
//else echo "OK";

?>