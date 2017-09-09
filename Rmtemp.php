<?php	
session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{	cambiar_ventana("index.php");	exit;	}
	
//Definicion de Variables
	$cprovee=$_POST['Caja1'];
	$cclient=$_POST['Caja2'];
	$link=conectarse("Apdahum");			
//Verificación de datos para reporte
	if($cprovee==0 && $cclient==0)
	{
		header("Location: rep_medic1.php?cod1=$cprovee");
		exit;
	}
	else
	{
		if($cprovee!=0 && $cclient==0)
		{
			header("Location: rep_medic1.php?cod1=$cprovee");
			exit;
		}
		else
		{
			$selec="SELECT tipo_cliente FROM Cliente WHERE Nit='$cclient'";
			$dato=mysql_query($selec,$link);
			while($row=mysql_fetch_array($dato))
			{
				$tipo=$row['tipo_cliente'];
			}
			header("Location: rep_medic2.php?cod1=$cprovee&cod2=$tipo");
			exit;
		}
	}
?>