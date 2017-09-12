<?php
	session_start();
	include("sysconect.php");
	if ($_SESSION['Bandera'] != "SI")	{		cambiar_ventana("index.php");		exit;	}
	$link=conectarse("Apdahum");
	
	$select="SELECT salida, medicamento, cantidad FROM VENTAS WHERE cliente=128 and ano=2013 order by factura";
	$busca=mysql_query($select,$link);
	while($x=mysql_fetch_array($busca))
	{
		$salida=$x['salida'];
		$idmedi=$x['medicamento'];
		$cantid=$x['cantidad'];
		
		$select="SELECT preciocosto FROM Bodegam WHERE id_producto='$idmedi'";
		$buscar=mysql_query($select,$link);
		while($y=mysql_fetch_array($buscar,$link))	{	$costo=$y['preciocosto'];	}
		$total=$cantid*$costo;
		$cambio="UPDATE Ventas SET punitario='$costo', total='$total' WHERE salida='$salida'";
		$registro=mysql_query($cambio,$link);

	}
	error_msg("Termine...");
	exit;
	
	
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
