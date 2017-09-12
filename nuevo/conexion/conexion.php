<?php 

$server = "localhost";
$user = "root";
$password = "";
$db = "apdahumf2";

$conexion = mysqli_connect($server, $user, $password, $db);
if (!$conexion) {
	die('Error de Conexión: ' . mysqli_connect_errno());
}
 ?>