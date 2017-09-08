<?php 
	session_start();
	include("sysconect.php");
	$Usr=$_POST["usuario"];
	$Pwd=$_POST["password"];
	$Pwd = md5($Pwd);
	$link = conectarse("apdahum");
	$sele = "select usuario, nombre, nip, id_puesto from empleado where usuario = '$Usr' and password = '$Pwd' and activo = 1";
	$rs_ya = @mysql_query($sele,$link);
	if($row = @mysql_fetch_array($rs_ya))
	{
		$Usr= $row["usuario"];
		$Nombre= $row["nombre"];
		$Nip= $row["nip"];
		$Nivel=$row["id_puesto"];
		$Bandera = "SI";
	}
	else	{		$Bandera = "NO";	}
	if ($Bandera == "SI")	{		$Bfarmacia="APDAHUM";	header("Location: principal.php");		exit;		}
	else					{		header("Location: error_login.htm");	exit;	}
?>