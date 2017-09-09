<?php 

$server = "localhost";
$user = "root";
$password = "Passw0rd123";
$db = "apdahumf2";

$conexion = mysqli_connect($server, $user, $password, $db);
if (!$conexion) {
	die('Error de Conexión: ' . mysqli_connect_errno());
}
 ?>