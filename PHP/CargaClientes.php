<?php 
include("../nuevo/conexion/conexion.php");


$query = "SELECT ifnull(max(NIT + 1),1) as codigo FROM cliente";
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