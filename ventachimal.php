<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	
	$listado="SELECT medicamento, tipomed, cantidad FROM ventas WHERE operado='S' AND cliente=355 ORDER BY medicamento";
	$buscar=mysql_query($listado,$link);
	while($x=mysql_fetch_array($buscar))
	{
		$idproduc=$x['medicamento'];
		$cantidad=$x['cantidad'];
		$tipopro=$x['tipomed'];
		$buscabodega="SELECT existencia, preciovp FROM Bodegam WHERE id_producto='$idproduc'";
		$busca2=mysql_query($buscabodega,$link);
		while($y=mysql_fetch_array($busca2))
		{
			$existencia=$y['existencia'];
			$preciovent=$y['preciovp'];
			if($existencia>=$cantidad)
			{
				$hoy=date('Y-m-d');
				$total=($preciovent*$cantidad);
			$selec="INSERT INTO 				
					Ventas(Salida,Cliente,Medicamento,Tipomed,Cantidad,Punitario,Descuentos,Total,Fecha,Usuario,Factura,Ano) 
					VALUES ('','362','$idproduc','$tipopro','$cantidad','$preciovent','0','$total','$hoy','$Usr',0,'2014')";
			$registro1=mysql_query($selec,$link);
			
			$ahora=$existencia-$cantidad;
			$selec="UPDATE Bodegam SET Existencia='$ahora' WHERE id_producto='$idproduc'";
			$registro2=mysql_query($selec,$link);	
			}
			else
			{
				$registro="INSERT INTO nohay values($idproduc)";
				$grabar=mysql_query($registro,$link);
			}
			
		}
		echo "Termine...";
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML><!-- InstanceBegin template="/Templates/layout.dwt" codeOutsideHTMLIsLocked="false" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Dise&ntilde;o y Programaci&oacute;n LDCP</TITLE>
<!-- InstanceEndEditable --><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<style type="text/css">
<!--
.Estilo54 {font-size: 9px}
-->
</style>
<style type="text/css">
<!--
.Estilo55 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<style type="text/css">
<!--
.Estilo57 {font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo58 {font-size: 14}
-->
</style>
<style type="text/css">
<!--
.Estilo59 {font-size: 12px}
-->
</style>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
-->
</style><!-- InstanceEndEditable -->
<link href="tablas-eec.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></HEAD>

<BODY>
<div align="center" class="tablas" id="1"><!-- InstanceBeginEditable name="contenido" -->
  <p>&nbsp;</p>
  <p>&nbsp;</p>
<!-- InstanceEndEditable --></div>
<p align="center">&nbsp;</p>
</BODY>
<!-- InstanceEnd --></HTML>
