<?php 
include("../nuevo/conexion/conexion.php");


$query = "SELECT * FROM menu where Padre = 0";
$resultado = mysqli_query($conexion,$query);
if (!$resultado) {
	die("No se encontraron Datos");
}else
{
	while($data = mysqli_fetch_assoc($resultado)){
		$array["data"][] = $data;
	}
	echo json_encode($array);
}

mysqli_free_result($resultado);
mysqli_close($conexion);

 ?>